<nav class="navbar navbar-expand-lg app-navbar sticky-top">
  <div class="container app-navbar-inner">
    <a class="navbar-brand app-brand" href="/">Kitabxana</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle app-user-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <?=$user->full_name?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end app-dropdown">
            <?php if($user->is_admin):?>
            <li><a class="dropdown-item" href="javascript:void(0)"  data-bs-toggle="modal" data-bs-target="#addBook" >Kitab əlavə et</a></li>
            <li><a class="dropdown-item" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#usersModal" >İstifadəçilər</a></li>
            <li><hr class="dropdown-divider"></li>
            <?php endif;?>
            <li><a class="dropdown-item" href="/logout">Çıxış</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
<div class="container app-shell">
  <div class="row mt-4 justify-content-center">
    <div class="col-lg-8 col-xl-7" id="searchFormWrapper">
      <form action="" class="search-panel" id="searchForm" autocomplete="off">
        <div class="d-flex gap-2">
          <input type="text" name="search" class="form-control app-input" placeholder="Kitab adı və ya açıqlama üzrə axtar" value="<?=$search?>">
          <button class="btn btn-primary app-btn-primary">Axtar</button>
        </div>
        <p class="small text-secondary mt-2 mb-0 d-block" id="bookCountText">Cəmi <?=$count??0?> kitab tapıldı</p>
      </form>
    </div>
  </div>
  <div id="booksSection">
  <div class="row g-4 mt-1" id="booksList">
    <?php for($i=0;$i<count($books);$i++):?>
    <div class="col-md-6 col-lg-4 col-xl-3">
      <article class="card book-card h-100">
        <div class="card-body d-flex flex-column">
          <div class="book-badge">PDF</div>
          <h5 class="card-title text-clamp-1"><?=$books[$i]->name?></h5>
          <p class="card-text text-clamp-2 small text-secondary book-desc"><?=$books[$i]->description?></p>
          <a href="/<?=$books[$i]->file ?>" target="_blank" rel="noopener" data-pdf="/<?=$books[$i]->file ?>" class="btn btn-primary mt-auto show-book app-btn-primary">Kitabı göstər</a>
          <?php if($user->is_admin):?>
            <div class="d-grid gap-2 mt-2">
              <a href="javascript:void(0)" data-id="<?=$books[$i]->id?>" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="edit-book btn btn-outline-primary">Redaktə et</a>
              <a href="javascript:void(0)" data-id="<?=$books[$i]->id?>" data-bs-toggle="modal" data-bs-target="#deleteModal" class="del-book btn btn-outline-danger">Sistemdən sil</a>
            </div>
          <?php endif;?>
        </div>  
      </article>
    </div>
    <?php endfor;?>
    <div class="mt-4 app-pagination-wrap">
        <?=$pagination?>
    </div>
  </div>
  </div>

             <!-- Modal -->
  <div class="modal fade" id="addBook" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addBook" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="addBookLabel">Kitab əlavə et</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="javascript:void(0)" id="add_form" method="post" autocomplete="off">
            <div class="row">
              <label for="" class="form-label">
                <small class="d-block w-100 mb-2" >Kitabın adı</small>
                <input type="text" id="add_name" class="form-control col-12" name="add_book_name">
              </label>
              <label for="" class="form-label">
                <small class="d-block w-100 mb-2">Kitabın açıqlaması</small>
                <textarea type="text" rows="11"  id="add_description" class="form-control col-12" name="add_book_description"></textarea>
              </label>
              <label for="" class="form-label">
                <small class="d-block w-100 mb-2">Fayl</small>
                <input type="file" id="add_file" name="add_book_file" class="form-control col-12" accept="application/pdf,.pdf"></input>
              </label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
          <button type="button" id="add_save" class="btn btn-primary">Yadda saxla</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="staticBackdropLabel">Redaktə</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="javascript:void(0)" id="edit_form" method="post" autocomplete="off">
            <div class="row">
              <label for="" class="form-label">
                <small class="d-block w-100 mb-2" >Kitabın adı</small>
                <input type="text" id="edit_name" class="form-control col-12" name="book_name">
              </label>
              <label for="" class="form-label">
                <small class="d-block w-100 mb-2">Kitabın açıqlaması</small>
                <textarea type="text" rows="11"  id="edit_description" class="form-control col-12" name="book_description"></textarea>
              </label>
              <label for="" class="form-label">
                <small class="d-block w-100 mb-2">Fayl</small>
                <input type="file" id="edit_file" name="book_file" class="form-control col-12" accept="application/pdf,.pdf"></input>
              </label>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
          <button type="button" id="edit_save" class="btn btn-primary">Yadda saxla</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal modal-xl fade" id="bookViewerModal" data-bs-backdrop="static" data-bs-keyboard="true" tabindex="-1" aria-labelledby="bookViewerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 98vw;">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="bookViewerModalLabel">Kitab</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-0">
          <div class="pdf-scroll-wrap" id="pdfScrollWrap"></div>
        </div>
        <div class="modal-footer">
          <a id="bookPdfOpenNew" href="#" target="_blank" rel="noopener" class="btn btn-outline-primary">Yeni pəncərədə aç</a>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="deleteModalLabel">Təstiqlə</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Kitabı silmək istədiyinizdən əminsiniz?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
          <button type="button" class="btn btn-danger" id="del-confirm">Sistemdən sil</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal modal-lg fade" id="usersModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="usersModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="usersModalLabel">İstifadəçilər</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="usersModalBody">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="userDeleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userDeleteModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="userDeleteModalLabel">İstifadəçilər</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="userDeleteModalBody">
          İstifadəçini silmək istədiyinizdən əminsiniz mi?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
          <button type="button" class="btn btn-danger" id="delUserConfirm">Sistemdən sil</button>
        </div>
      </div>
    </div>
  </div>


   <!-- Modal -->
  <div class="modal fade" id="userInfoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userModalInfo" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="userInfoModalLabel">İstifadəçi əlavə et</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="userInfoModalBody">
            <form action="javascript:void(0)" method="post" id="addUserForm" class="row" autocomplete="off">
                <label for="userEmail" class="form-label">
                  <small class="d-block mb-2">Email</small>
                  <input type="text" class="form-control w-full" id="userEmail" name="user_email">
                </label>
                <label for="userFullName" class="form-label">
                  <small class="d-block mb-2">Tam ad</small>
                  <input type="text" class="form-control w-full" id="userFullName" name="user_full_name">
                </label>
                <label for="userPassword" class="form-label">
                  <small class="d-block mb-2">Şifrə</small>
                  <input type="password" class="form-control w-full" id="userPassword" name="user_password">
                </label>
                <label for="userRole" class="form-label">
                  <small class="d-block mb-2">Rol</small>
                  <select name="user_role" id="userRole" class="form-control">
                    <option value="1">Admin</option>
                    <option value="0">İstifadəçi</option>
                  </select>
                </label>
                <label for="userRole" class="form-label">
                  <button type="submit" class="btn btn-primary w-100" id="addUserFormBtn">Yadda saxla</button>
                </label>
            </form>
            <div id="addUserAlert"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Modal -->
  <div class="modal fade" id="userInfoEditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="userInfoEditModal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="userInfoEditModalLabel">İstifadəçi əlavə et</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="userInfoEditBody">
            <form action="javascript:void(0)" method="post" id="editUserForm" class="row" autocomplete="off">
                <label for="userEmail" class="form-label">
                  <small class="d-block mb-2">Email</small>
                  <input type="text" class="form-control w-full" id="editUserEmail" name="user_email">
                </label>
                <label for="userFullName" class="form-label">
                  <small class="d-block mb-2">Tam ad</small>
                  <input type="text" class="form-control w-full" id="editUserFullName" name="user_full_name">
                </label>
                <label for="userPassword" class="form-label">
                  <small class="d-block mb-2">Şifrə</small>
                  <input type="password" class="form-control w-full" id="editUserPassword" name="user_password">
                </label>
                <label for="userRole" class="form-label">
                  <small class="d-block mb-2">Rol</small>
                  <select name="user_role" id="editUserRole" class="form-control">
                    <option value="1">Admin</option>
                    <option value="0">İstifadəçi</option>
                  </select>
                </label>
                <label for="userRole" class="form-label">
                  <button type="submit" class="btn btn-primary w-100" id="editUserFormBtn">Yadda saxla</button>
                </label>
            </form>
            <div id="editUserAlert"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bağla</button>
        </div>
      </div>
    </div>
  </div>

  <div class="toast-container position-fixed top-0 end-0 p-3" id="toastContainer" style="z-index: 1080;"></div>

</div>
