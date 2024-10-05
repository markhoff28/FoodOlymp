<div class="vertical-menu">

  <div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
      <!-- Left Menu Start -->
      <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title" data-key="t-menu">Your Backoffice</li>

        <li>
          <a href="{{ route('admin.dashboard') }}">
            <i class='bx bx-home-alt'></i>
            <span data-key="t-dashboard">Dashboard</span>
          </a>
        </li>

        @if (Auth::guard('admin')->user()->can('category.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class="bx bx-category"></i>
            <span data-key="t-apps">Category</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            @if (Auth::guard('admin')->user()->can('category.all'))
            <li>
              <a href="{{ route('all.category') }}">
                <span data-key="t-calendar">All Category</span>
              </a>
            </li>
            @endif
            @if (Auth::guard('admin')->user()->can('category.add'))
            <li>
              <a href="{{ route('add.category') }}">
                <span data-key="t-chat">Add Category</span>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif

        @if (Auth::guard('admin')->user()->can('product.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class="bx bx-category"></i>
            <span data-key="t-apps">Manage Product</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            @if (Auth::guard('admin')->user()->can('product.all'))
            <li>
              <a href="{{ route('admin.all.product') }}">
                <span data-key="t-calendar">All Product</span>
              </a>
            </li>
            @endif
            @if (Auth::guard('admin')->user()->can('product.add'))
            <li>
              <a href="{{ route('admin.add.product') }}">
                <span data-key="t-chat">Add Product</span>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif

        @if (Auth::guard('admin')->user()->can('restaurant.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class="bx bx-restaurant"></i>
            <span data-key="t-apps">Manage Restaurant</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            <li>
              <a href="{{ route('pending.restaurant') }}">
                <span data-key="t-calendar">Pending Restaurant </span>
              </a>
            </li>
            <li>
              <a href="{{ route('approve.restaurant') }}">
                <span data-key="t-chat">Approve Restaurant </span>
              </a>
            </li>
          </ul>
        </li>
        @endif

        @if (Auth::guard('admin')->user()->can('order.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class='bx bx-cart'></i>
            <span data-key="t-apps">Manage Orders</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            <li>
              <a href="{{ route('pending.order') }}">
                <span data-key="t-calendar">Pending Orders </span>
              </a>
            </li>
            <li>
              <a href="{{ route('confirm.order') }}">
                <span data-key="t-calendar">Confirm Orders </span>
              </a>
            </li>
            <li>
              <a href="{{ route('processing.order') }}">
                <span data-key="t-calendar">Processing Orders </span>
              </a>
            </li>
            <li>
              <a href="{{ route('deliverd.order') }}">
                <span data-key="t-calendar">Deliverd Orders </span>
              </a>
            </li>

          </ul>
        </li>
        @endif

        @if (Auth::guard('admin')->user()->can('city.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class='bx bx-location-plus'></i>
            <span>City</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            @if (Auth::guard('admin')->user()->can('city.all'))
            <li>
              <a href="{{ route('all.city') }}">
                <span>All City</span>
              </a>
            </li>
            @endif
          </ul>
        </li>
        @endif

        @if (Auth::guard('admin')->user()->can('review.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class="bx bx-edit"></i>
            <span data-key="t-apps">Manage Review</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            @if (Auth::guard('admin')->user()->can('review.pending'))
            <li>
              <a href="{{ route('admin.pending.review') }}" data-key="t-lightbox">Pending Review</a>
            </li>
            @endif
            @if (Auth::guard('admin')->user()->can('review.approve'))
            <li>
              <a href="{{ route('admin.approve.review') }}" data-key="t-range-slider">Approve Review</a>
            </li>
            @endif
          </ul>
        </li>
        @endif

        @if (Auth::guard('admin')->user()->can('business.intelligence.user'))
        <li class="menu-title mt-2" data-key="t-components">Business Intelligence</li>

        @if (Auth::guard('admin')->user()->can('report.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class="bx bx-line-chart"></i>
            <span data-key="t-apps">Manage Reports</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            <li>
              <a href="{{ route('admin.all.reports') }}" data-key="t-alerts">All Reports</a>
            </li>

          </ul>
        </li>
        @endif
        @endif

        @if (Auth::guard('admin')->user()->can('content.management.user'))
        <li class="menu-title mt-2" data-key="t-components">Content Management</li>

        @if (Auth::guard('admin')->user()->can('banner.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class="bx bx-image"></i>
            <span data-key="t-apps">Manage Banner</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            <li>
              <a href="{{ route('all.banner') }}">
                <span data-key="t-calendar">All Banner </span>
              </a>
            </li>

          </ul>
        </li>
        @endif
        @endif

        @if (Auth::guard('admin')->user()->can('admin.user.menu'))
        <li class="menu-title mt-2" data-key="t-components">Administration</li>

        @if (Auth::guard('admin')->user()->can('role.permission.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class="bx bx-user-check"></i>
            <span data-key="t-ui-elements">Role & Permission</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('all.permission') }}" data-key="t-lightbox">All Permission</a></li>
            <li><a href="{{ route('all.roles') }}" data-key="t-range-slider">All Roles</a></li>
            <li><a href="{{ route('add.roles.permission') }}" data-key="t-range-slider">Role In Permission</a></li>
            <li><a href="{{ route('all.roles.permission') }}" data-key="t-range-slider">All Role In Permission</a></li>

          </ul>
        </li>
        @endif
        @if (Auth::guard('admin')->user()->can('user.management.menu'))
        <li>
          <a href="javascript: void(0);" class="has-arrow">
            <i class="bx bx-user-check"></i>
            <span data-key="t-ui-elements">Manage Admin</span>
          </a>
          <ul class="sub-menu" aria-expanded="false">
            <li><a href="{{ route('all.admin') }}" data-key="t-lightbox">All Admin</a></li>
            <li><a href="{{ route('add.admin') }}" data-key="t-range-slider">Add Admin</a></li>

          </ul>
        </li>
        @endif
        @endif

        <li class="menu-title mt-2" data-key="t-components">Additional services</li>

        <li>
          <a href="javascript: void(0);">
          <i class="bx bx-support"></i>
            <span data-key="t-components">Support</span>
          </a>
        </li>


      </ul>

      <div class="card sidebar-alert border-0 text-center mx-4 mb-0 mt-5">
        <div class="card-body">
          <img src="{{ asset('backend/assets/images/giftbox.png') }}" alt="">
          <div class="mt-4">
            <h5 class="alertcard-title font-size-16">Unlimited Access</h5>
            <p class="font-size-13">Upgrade your plan from a Free trial, to select ‘Business Plan’.</p>

          </div>
        </div>
      </div>
    </div>
    <!-- Sidebar -->
  </div>
</div>