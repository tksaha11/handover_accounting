<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">

        <div>
            <h4 class="logo-text">AmarDokan</h4>
        </div>
        <a href="javascript:;" class="toggle-btn ml-auto"> <i class="bx bx-menu"></i>
        </a>
    </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        <li>
            <a href="{{ route('dashboard') }}">
                <div class="parent-icon icon-color-1"><i class="bx bx-home-alt"></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        <li class="menu-label">Products</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon icon-color-1"><i class="fadeIn animated bx bx-collection"></i>
                </div>
                <div class="menu-title">Products</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('shop-live-products') }}">
                        <div class="parent-icon icon-color-4">
                            <i class="fadeIn animated bx bx-store-alt"></i>
                        </div>
                        <div class="menu-title">Shop Live Products</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('my-product-list') }}">
                        <div class="parent-icon icon-color-5">
                            <i class="fadeIn animated bx bx-layer"></i>
                        </div>
                        <div class="menu-title">My Product List</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('amardokan-product-for-add') }}">
                        <div class="parent-icon icon-color-3"> <i class="fadeIn animated bx bx-plus-circle"></i>
                        </div>
                        <div class="menu-title">Add from Amardokan</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('upload-own-product-form') }}">
                        <div class="parent-icon icon-color-1"><i class="fadeIn animated bx bx-export"></i>
                        </div>
                        <div class="menu-title">Upload Own Product</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('mrp-change-request') }}">
                        <div class="parent-icon icon-color-1"><i class="bi bi-arrow-left-right"></i>
                        </div>
                        <div class="menu-title">MRP Change Request</div>
                    </a>
                </li>
            </ul>
        </li>


        <li class="menu-label">Campaigns</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon icon-color-1"><i class="fadeIn animated bx bx-collection"></i>
                </div>
                <div class="menu-title">Campaigns</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('campaign-special-combo') }}">
                        <div class="parent-icon icon-color-4"><i class="fadeIn animated bx bx-collection"></i>
                        </div>
                        <div class="menu-title">Special Combo Offer</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('campaign-discount') }}">
                        <div class="parent-icon icon-color-5"><i class="fadeIn animated bx bx-diamond"></i>
                        </div>
                        <div class="menu-title">Discount Offer</div>
                    </a>
                </li>
                <li>
                    <a href="{{ route('seller-campaign') }}">
                        <div class="parent-icon icon-color-6"><i class="fadeIn animated bx bx-purchase-tag-alt"></i>
                        </div>
                        <div class="menu-title">Seller Campaign</div>
                    </a>
                </li>

            </ul>
        </li>


        <li class="menu-label">Purchase from Admin</li>
        <li>
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon icon-color-8"><i class="fadeIn animated bx bx-cart-alt"></i>
                </div>
                <div class="menu-title">Purchase From Amardokan</div>
            </a>
            <ul>
                <li>
                    <a href="{{ route('b2b-new-arrival') }}">
                        <div class="parent-icon icon-color-8"><i class="fadeIn animated bx bx-cart-alt"></i>
                        </div>
                        <div class="menu-title">New Arival</div>
                    </a>
                </li>
                <li>
                    <a  href="{{ route('b2b-all-suppliers') }}">
                        <div class="parent-icon icon-color-10"><i class="fadeIn animated bx bx-table"></i>
                        </div>
                        <div class="menu-title">All Brands</div>
                    </a>
                </li>
                <li>
                    <a  href="{{ route('b2b-order-list') }}">
                        <div class="parent-icon icon-color-11"><i class="fadeIn animated bx bx-list-ul"></i>
                        </div>
                        <div class="menu-title">Order List</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-label">Sales</li>
        <li>
            <a  href="{{ route('order-list') }}">
                <div class="parent-icon icon-color-12"> <i class="fadeIn animated bx bx-receipt"></i>
                </div>
                <div class="menu-title">Orders</div>
            </a>
        </li>
        <li>
            <a  href="{{ route('pending-list') }}">
                <div class="parent-icon icon-color-12"> <i class="fadeIn animated bx bx-receipt"></i>
                </div>
                <div class="menu-title">Pending List</div>
            </a>
        </li>
        <li>
            <a  href="{{ route('delivered-list') }}">
                <div class="parent-icon icon-color-12"> <i class="fadeIn animated bx bx-receipt"></i>
                </div>
                <div class="menu-title">Delivered List</div>
            </a>
        </li>
        <li>
            <a  href="{{ route('processing-list') }}">
                <div class="parent-icon icon-color-12"> <i class="fadeIn animated bx bx-receipt"></i>
                </div>
                <div class="menu-title">Processing List</div>
            </a>
        </li>
        <li>
            <a  href="{{ route('canceled-list') }}">
                <div class="parent-icon icon-color-12"> <i class="fadeIn animated bx bx-receipt"></i>
                </div>
                <div class="menu-title">Canceled List</div>
            </a>
        </li>
        
        <li class="menu-label">Customers</li>
        <li>
            <a  href="{{ route('all-customer-list') }}">
                <div class="parent-icon icon-color-1"><i class="fadeIn animated bx bx-user"></i>
                </div>
                <div class="menu-title">All Customer List</div>
            </a>
        </li>
        <li>
            <a  href="{{ route('customer-reg-form') }}">
                <div class="parent-icon icon-color-1"><i class="fadeIn animated bx bx-user"></i>
                </div>
                <div class="menu-title">Customer Registration</div>
            </a>
        </li>
        <li>
            <a  href="{{ route('customer-list') }}">
                <div class="parent-icon icon-color-1"><i class="fadeIn animated bx bx-user"></i>
                </div>
                <div class="menu-title">Registered Customer List</div>
            </a>
        </li>
        <li class="menu-label">Delivery Service</li>
    	<li>
            <a  href="{{ route('all-delivery-man-list') }}">
                <div class="parent-icon icon-color-1"><i class="fadeIn animated bx bx-user"></i>
                </div>
                <div class="menu-title">All Delivery Man List</div>
            </a>
        </li>
        <li>
            <a  href="{{ route('create-delivery-man') }}">
                <div class="parent-icon icon-color-1"><i class="fadeIn animated bx bx-user"></i>
                </div>
                <div class="menu-title">Create Delivery Man</div>
            </a>
        </li>
        <li>
            <a  href="{{ route('delivery-man-list') }}">
                <div class="parent-icon icon-color-1"><i class="fadeIn animated bx bx-user"></i>
                </div>
                <div class="menu-title">Delivery Man List</div>
            </a>
        </li>
        <li class="menu-label">ABL Accounts</li>
        <li>
            <a  href="{{ route('payable-to-abl') }}">
                <div class="parent-icon icon-color-2"><i class="fadeIn animated bx bx-wallet"></i>
                </div>
                <div class="menu-title">Payable to ABL</div>
            </a>
        </li>
        <li>
            <a  href="{{ route('paid-list') }}">
                <div class="parent-icon icon-color-4"><i class="fadeIn animated bx bx-check-circle"></i>
                </div>
                <div class="menu-title">Paid</div>
            </a>
        </li>
        <li class="menu-label">Accounts</li>
        <li>
            <a href="{{ route('accounts') }}">
                <div class="parent-icon icon-color-5">
                    <i class="fadeIn animated bx bx-money"></i>
                </div>
                <div class="menu-title">Daily Accounts</div>
            </a>
        </li>
        <li class="menu-label">Others</li>
        <li>
            <a href="{{ route('support') }}">
                <div class="parent-icon"><i class="bx bx-support"></i>
                </div>
                <div class="menu-title">Support</div>
            </a>
        </li>
    </ul>
    <!--end navigation-->
</div>
