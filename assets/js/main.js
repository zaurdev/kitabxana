$(function () {
  let editId = null;
  let delId = null;
  let delUserId = null;
  let editUserId = null;
  let currentPdfTask = null;
  let pdfSessionId = 0;

  function showToast(message, type = "success") {
    const id = `toast-${Date.now()}`;
    const html = `
      <div id="${id}" class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
          <div class="toast-body">${message}</div>
          <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
      </div>
    `;
    $("#toastContainer").append(html);
    const el = document.getElementById(id);
    const toast = new bootstrap.Toast(el, { delay: 3000 });
    toast.show();
    el.addEventListener("hidden.bs.toast", () => el.remove());
  }

  function setButtonLoading(selector, text) {
    $(selector).html(`
      ${text}
      <div class="spinner-border spinner-border-sm" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    `);
    $(selector).attr("disabled", true);
  }

  function resetButton(selector, text) {
    $(selector).html(text);
    $(selector).attr("disabled", false);
  }

  function isPdfFile(file) {
    if (!file) return false;
    const name = (file.name || "").toLowerCase();
    return file.type === "application/pdf" || name.endsWith(".pdf");
  }

  function validatePdfInput(inputSelector, required = false) {
    const fileInput = $(inputSelector)[0];
    if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
      if (required) {
        showToast("Yalniz PDF fayli secmelisiniz.", "danger");
        return false;
      }
      return true;
    }
    if (!isPdfFile(fileInput.files[0])) {
      showToast("Yalniz PDF fayli yuklemek olar.", "danger");
      fileInput.value = "";
      return false;
    }
    return true;
  }

  function loadBooks(url, pushState = true) {
    $.ajax({
      method: "get",
      url: url,
      dataType: "html",
      success: (html) => {
        const doc = $($.parseHTML(html));
        const booksSection = doc.find("#booksSection").html();
        const searchFormWrapper = doc.find("#searchFormWrapper").html();
        if (booksSection) {
          $("#booksSection").html(booksSection);
        }
        if (searchFormWrapper) {
          $("#searchFormWrapper").html(searchFormWrapper);
        }
        if (pushState) {
          window.history.pushState({}, "", url);
        }
      },
      error: () => {
        showToast("Kitablar yenilenirken xeta bas verdi.", "danger");
      },
    });
  }

  function loadUsers(url = "/users/get_users/0") {
    $.ajax({
      method: "get",
      url: url,
      success: (response) => {
        $("#usersModalBody").html(response.table);
      },
      error: () => {
        showToast("Istifadeci siyahisi yuklenmedi.", "danger");
      },
    });
  }

  $(window).on("popstate", () => {
    loadBooks(window.location.pathname + window.location.search, false);
  });

  $(document).on("submit", "#searchForm", (e) => {
    e.preventDefault();
    const params = new URLSearchParams($(e.currentTarget).serialize());
    const url = `${window.location.pathname}?${params.toString()}`;
    loadBooks(url, true);
  });

  $(document).on("click", "#booksSection .pagination a", (e) => {
    e.preventDefault();
    const url = $(e.currentTarget).attr("href");
    if (url) loadBooks(url, true);
  });

  $(document).on("click", ".edit-book", (e) => {
    editId = $(e.currentTarget).data("id");
    $.ajax({
      method: "get",
      url: `/book/${editId}`,
      success: (book) => {
        $("#edit_name").val(book.name || "");
        $("#edit_description").val(book.description || "");
        $("#edit_file").val("");
      },
    });
  });

  $(document).on("click", ".del-book", (e) => {
    delId = $(e.currentTarget).data("id");
  });

  $(document).on("change", "#add_file, #edit_file", function () {
    validatePdfInput(`#${this.id}`, false);
  });

  $(document).on("click", ".show-book", (e) => {
    const pdfUrl = $(e.currentTarget).data("pdf");
    const isPdf = typeof pdfUrl === "string" && pdfUrl.toLowerCase().endsWith(".pdf");
    if (!isPdf) {
      e.preventDefault();
      showToast("Bu kitab fayli PDF formatinda deyil.", "warning");
      return;
    }
    e.preventDefault();
    $("#bookPdfOpenNew").attr("href", pdfUrl);
    const viewerModal = new bootstrap.Modal(document.getElementById("bookViewerModal"));
    viewerModal.show();
    renderPdfContinuous(pdfUrl);
  });

  $("#bookViewerModal").on("hidden.bs.modal", () => {
    pdfSessionId += 1;
    if (currentPdfTask && currentPdfTask.destroy) {
      currentPdfTask.destroy();
    }
    currentPdfTask = null;
    $("#pdfScrollWrap").html("");
    $("#bookPdfOpenNew").attr("href", "#");
  });

  async function renderPdfContinuous(pdfUrl) {
    const sessionId = ++pdfSessionId;
    const wrap = document.getElementById("pdfScrollWrap");
    wrap.innerHTML = '<div class="p-3 text-secondary">Yüklənir...</div>';
    if (!window.pdfjsLib) {
      wrap.innerHTML = "";
      showToast("PDF oxuyucu yüklənmədi.", "danger");
      return;
    }

    if (currentPdfTask && currentPdfTask.destroy) {
      currentPdfTask.destroy();
    }
    window.pdfjsLib.GlobalWorkerOptions.workerSrc =
      "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js";
    currentPdfTask = window.pdfjsLib.getDocument(pdfUrl);

    try {
      const pdf = await currentPdfTask.promise;
      if (sessionId !== pdfSessionId) return;
      wrap.innerHTML = "";
      for (let pageNum = 1; pageNum <= pdf.numPages; pageNum += 1) {
        if (sessionId !== pdfSessionId) return;
        const page = await pdf.getPage(pageNum);
        const baseViewport = page.getViewport({ scale: 1 });
        const containerWidth = Math.max(320, wrap.clientWidth - 24);
        const scale = containerWidth / baseViewport.width;
        const viewport = page.getViewport({ scale: scale * (window.devicePixelRatio || 1) });

        const pageBox = document.createElement("div");
        pageBox.className = "pdf-page-box";
        const canvas = document.createElement("canvas");
        const ctx = canvas.getContext("2d");
        canvas.width = Math.floor(viewport.width);
        canvas.height = Math.floor(viewport.height);
        canvas.style.width = `${Math.floor(viewport.width / (window.devicePixelRatio || 1))}px`;
        canvas.style.height = `${Math.floor(viewport.height / (window.devicePixelRatio || 1))}px`;
        pageBox.appendChild(canvas);
        wrap.appendChild(pageBox);

        await page.render({ canvasContext: ctx, viewport }).promise;
      }
    } catch (err) {
      if (sessionId !== pdfSessionId) return;
      wrap.innerHTML = "";
      showToast("PDF açılarkən xəta baş verdi.", "danger");
    }
  }

  function editBook() {
    if (!editId) return;
    if (!validatePdfInput("#edit_file", false)) return;
    const formData = new FormData($("#edit_form")[0]);
    setButtonLoading("#edit_save", "Gozleyin");
    $.ajax({
      method: "post",
      url: `/book/edit/${editId}`,
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: () => {
        resetButton("#edit_save", "Yadda saxla");
        const editModal = bootstrap.Modal.getInstance(document.getElementById("staticBackdrop"));
        if (editModal) editModal.hide();
        loadBooks(window.location.pathname + window.location.search, false);
        showToast("Kitab melumatlari yenilendi.", "success");
      },
      error: (xhr) => {
        resetButton("#edit_save", "Yadda saxla");
        showToast(xhr.responseJSON?.message || "Kitab yenilenmedi.", "danger");
      },
    });
  }

  function addBook() {
    if (!validatePdfInput("#add_file", true)) return;
    const formData = new FormData($("#add_form")[0]);
    setButtonLoading("#add_save", "Gozleyin");
    $.ajax({
      method: "post",
      url: "/book/add",
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: () => {
        resetButton("#add_save", "Yadda saxla");
        $("#add_form")[0].reset();
        const addModal = bootstrap.Modal.getInstance(document.getElementById("addBook"));
        if (addModal) addModal.hide();
        loadBooks(window.location.pathname + window.location.search, false);
        showToast("Yeni kitab elave olundu.", "success");
      },
      error: (xhr) => {
        resetButton("#add_save", "Yadda saxla");
        showToast(xhr.responseJSON?.message || "Kitab elave edilmedi.", "danger");
      },
    });
  }

  $("#edit_save").on("click", (e) => {
    e.preventDefault();
    editBook();
  });

  $("#add_save").on("click", (e) => {
    e.preventDefault();
    addBook();
  });

  $("#edit_form").on("submit", (e) => {
    e.preventDefault();
    editBook();
  });

  $("#add_form").on("submit", (e) => {
    e.preventDefault();
    addBook();
  });

  $("#del-confirm").on("click", () => {
    if (!delId) return;
    setButtonLoading("#del-confirm", "Gozleyin");
    $.ajax({
      method: "get",
      url: `/book/delete/${delId}`,
      success: () => {
        resetButton("#del-confirm", "Sistemden sil");
        const delModal = bootstrap.Modal.getInstance(document.getElementById("deleteModal"));
        if (delModal) delModal.hide();
        loadBooks(window.location.pathname + window.location.search, false);
        showToast("Kitab sistemden silindi.", "success");
      },
      error: () => {
        resetButton("#del-confirm", "Sistemden sil");
        showToast("Kitab silinerken xeta bas verdi.", "danger");
      },
    });
  });

  $("#usersModal").on("shown.bs.modal", () => {
    loadUsers("/users/get_users/0");
  });

  $(document).on("click", "#usersModalBody .pagination a", (e) => {
    e.preventDefault();
    const url = $(e.currentTarget).attr("href");
    if (url) loadUsers(url);
  });

  $(document).on("click", ".del-user-btn", (e) => {
    delUserId = $(e.currentTarget).data("id");
  });

  $("#delUserConfirm").on("click", () => {
    if (!delUserId) return;
    setButtonLoading("#delUserConfirm", "Gozleyin");
    $.ajax({
      method: "get",
      url: `/users/delete/${delUserId}`,
      success: () => {
        resetButton("#delUserConfirm", "Sistemden sil");
        const delUserModal = bootstrap.Modal.getInstance(document.getElementById("userDeleteModal"));
        if (delUserModal) delUserModal.hide();
        loadUsers();
        showToast("Istifadeci sistemden silindi.", "success");
      },
      error: () => {
        resetButton("#delUserConfirm", "Sistemden sil");
        showToast("Istifadeci silinerken xeta bas verdi.", "danger");
      },
    });
  });

  $("#addUserForm").on("submit", (e) => {
    e.preventDefault();
    const obj = {};
    $("#addUserForm").serializeArray().forEach((item) => {
      obj[item.name] = item.value;
    });
    setButtonLoading("#addUserFormBtn", "Gozleyin");
    $.ajax({
      method: "post",
      url: "/users/add_user",
      data: obj,
      success: (response) => {
        if (response.error) {
          resetButton("#addUserFormBtn", "Yadda saxla");
          $("#addUserAlert").html(response.html);
          showToast("Istifadeci elave edilmedi.", "danger");
          return;
        }
        resetButton("#addUserFormBtn", "Yadda saxla");
        $("#addUserForm")[0].reset();
        $("#addUserAlert").html("");
        const addUserModal = bootstrap.Modal.getInstance(document.getElementById("userInfoModal"));
        if (addUserModal) addUserModal.hide();
        loadUsers();
        showToast("Yeni istifadeci elave olundu.", "success");
      },
      error: () => {
        resetButton("#addUserFormBtn", "Yadda saxla");
        showToast("Istifadeci elave edilmedi.", "danger");
      },
    });
  });

  $(document).on("click", ".edit-user-btn", (e) => {
    const button = $(e.currentTarget);
    button.html(`
      Gozleyin
      <div class="spinner-border spinner-border-sm" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    `);
    button.attr("disabled", true);
    editUserId = button.data("id");
    $.ajax({
      method: "get",
      url: `/users/get_user/${editUserId}`,
      success: (user) => {
        $("#editUserEmail").val(user.email || "");
        $("#editUserFullName").val(user.full_name || "");
        $("#editUserPassword").val("");
        $("#editUserRole").val(user.is_admin);
        button.html("Duzelt");
        button.attr("disabled", false);
      },
      error: () => {
        button.html("Duzelt");
        button.attr("disabled", false);
        showToast("Istifadeci melumatlari yuklenmedi.", "danger");
      },
    });
  });

  $("#editUserForm").on("submit", (e) => {
    e.preventDefault();
    const obj = {};
    $("#editUserForm").serializeArray().forEach((item) => {
      obj[item.name] = item.value;
    });
    setButtonLoading("#editUserFormBtn", "Gozleyin");
    $.ajax({
      method: "post",
      url: `/users/edit_user/${editUserId}`,
      data: obj,
      success: (response) => {
        if (response.error) {
          resetButton("#editUserFormBtn", "Yadda saxla");
          $("#editUserAlert").html(response.html);
          showToast("Istifadeci yenilenmedi.", "danger");
          return;
        }
        resetButton("#editUserFormBtn", "Yadda saxla");
        $("#editUserAlert").html("");
        const editUserModal = bootstrap.Modal.getInstance(document.getElementById("userInfoEditModal"));
        if (editUserModal) editUserModal.hide();
        loadUsers();
        showToast("Istifadeci melumatlari yenilendi.", "success");
      },
      error: () => {
        resetButton("#editUserFormBtn", "Yadda saxla");
        showToast("Istifadeci yenilenmedi.", "danger");
      },
    });
  });

  $(document).on("change", ".userRoleSwitcher", (e) => {
    const id = $(e.currentTarget).data("id");
    $.ajax({
      url: `/users/set_role/${id}`,
      data: { role_id: e.currentTarget.value },
      method: "post",
      success: () => {
        showToast("Istifadecinin rolu deyisdirildi.", "success");
      },
      error: () => {
        showToast("Rol deyisdirilerken xeta bas verdi.", "danger");
      },
    });
  });
});
