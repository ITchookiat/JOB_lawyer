@php
  function active($currect_page) {
    $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
    $url = end($url_array);
    if($currect_page == $url) {
      echo 'active'; //class name in css
    }
  }
@endphp

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('index','home') }}" class="brand-link">
      <img src="{{ asset('dist/img/logoHafizLaw.jpg') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Hafiz Law Office</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('dist/img/avatar5.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->username }}</a>
        </div>
      </div> -->

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column text-sm" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          @if(auth::user()->type == "Admin")
            <li class="nav-item has-treeview {{ Request::is('maindata/view*') ? 'menu-open' : '' }}">
              <a href="#" class="nav-link active">
                <i class="nav-icon fas fa-window-restore"></i>
                <p>
                  ข้อมูลหลัก
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview" style="margin-left: 15px;">
                <li class="nav-item">
                  <a href="{{ route('ViewMaindata') }}" class="nav-link active">
                    <i class="far fa-id-badge text-red nav-icon"></i>
                    <p>ข้อมูลผู้ใช้งานระบบ</p>
                  </a>
                </li>
              </ul>
            </li>
          @endif

          <li class="nav-item has-treeview {{ Request::is('lawyer/view/1') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-database"></i>
              <p>
                ทะเบียนลูกหนี้
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <li class="nav-item">
                <a href="{{ route('lawyer', 1) }}" class="nav-link {{ Request::is('lawyer/view/1') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายการเตรียมโนติส</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview {{ Request::is('Debtor/view/*') ? 'menu-open' : '' }}{{ Request::is('Debtor/edit/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-user-tag"></i>
              <p>
                ระบบติดตามลูกหนี้
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <li class="nav-item">
                <a href="{{ route('Debtor', 1) }}" class="nav-link {{ Request::is('Debtor/view/1') ? 'active' : '' }}{{ Request::is('Debtor/edit/*') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ติดตามลูกหนี้หลังฟ้อง</p>
                </a>
                <a href="{{ route('Debtor', 2) }}" class="nav-link {{ Request::is('Debtor/view/2') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>สรุปผลลูกหนี้หลังฟ้อง</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview {{ Request::is('Report/view/*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                รายงานลูกหนี้
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="margin-left: 15px;">
              <li class="nav-item">
                {{-- <a href="{{ route('Debtor', 2) }}" class="nav-link {{ Request::is('Debtor/view/2') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>ลูกหนี้แยกตามประเภท</p>
                </a> --}}
                <a href="{{ route('Report', 1) }}" class="nav-link {{ Request::is('Report/view/1') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายงานลูกหนี้ กู้-บุคคล</p>
                </a>
                <a href="{{ route('Report', 2) }}" class="nav-link {{ Request::is('Report/view/2') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายงานลูกหนี้ กู้-ทรัพย์</p>
                </a>
                <a href="#" class="nav-link {{ Request::is('Report/view/3') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายงานลูกหนี้สืบทรัพย์</p>  
                </a>
                <a href="#" class="nav-link {{ Request::is('Report/view/4') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายงานเบิกค่าใช้จ่ายลูกหนี้</p>  
                </a>
                <a href="#" class="nav-link {{ Request::is('Report/view/5') ? 'active' : '' }}">
                  <i class="far fa-dot-circle nav-icon"></i>
                  <p>รายงานลูกหนี้ปิดจบงาน</p>  
                </a>
              </li>
            </ul>
          </li>

          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link active">
              <i class="nav-icon far fa-handshake"></i>
              <p>
                เมนูแบบจัดกลุ่ม
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview">
                  <a href="#" class="nav-link">
                    <i class="far fa-window-restore text-red nav-icon"></i>
                    <p>
                      หัวข้อเมนู 1
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="margin-left: 15px;">
                    <li class="nav-item">
                      <a href="#" class="nav-link">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>เมนูย่อย 1.1</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('datacar/view/7') ? 'active' : '' }} {{ Request::is('datacar/edit/*/1') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>เมนูย่อย 1.2</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('datacar/view/2') ? 'active' : '' }} {{ Request::is('datacar/edit/*/2') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>เมนูย่อย 1.3</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>

              <ul class="nav nav-treeview">
                <li class="nav-item has-treeview {{ Request::is('reportcar/viewreport/3') ? 'menu-open' : '' }} {{ Request::is('reportcar/viewreport/4') ? 'menu-open' : '' }} {{ Request::is('reportcar/viewreport/5') ? 'menu-open' : '' }} {{ Request::is('reportcar/viewreport/6') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link">
                    <i class="far fa-window-restore text-red nav-icon"></i>
                    <p>
                    หัวข้อเมนู 2
                      <i class="right fas fa-angle-left"></i>
                    </p>
                  </a>
                  <ul class="nav nav-treeview" style="margin-left: 15px;">
                    <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('reportcar/viewreport/3') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>เมนูย่อย 2.1</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('reportcar/viewreport/4') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>เมนูย่อย 2.2</p>
                      </a>
                    </li>
                    <li class="nav-item">
                      <a href="#" class="nav-link {{ Request::is('reportcar/viewreport/5') ? 'active' : '' }}">
                        <i class="far fa-dot-circle nav-icon"></i>
                        <p>เมนูย่อย 2.3</p>
                      </a>
                    </li>
                  </ul>
                </li>
              </ul>
          </li> -->

        </ul>
      </nav>
    </div>
  </aside>
