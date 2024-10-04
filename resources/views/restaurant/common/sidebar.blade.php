<div class="ec-left-sidebar ec-bg-sidebar">
			<div id="sidebar" class="sidebar ec-sidebar-footer">

				<div class="ec-brand">
					<a href="{{url('restaurant/dashboard')}}" title="Restaurant">
                         
						 <img class="ec-brand-icon" src="{{asset('admin/assets/img/logo/ec-site-logo.png')}} " alt="" /> 
						
					</a>
				</div>

				<!-- begin sidebar scrollbar -->
				<div class="ec-navigation" data-simplebar>
					<!-- sidebar menu -->
					<ul class="nav sidebar-inner" id="sidebar-menu">
						<!-- Dashboard -->
						<li class="active">
							<a class="sidenav-item-link" href="{{url('restaurant/dashboard')}}">
								<i class="mdi mdi-view-dashboard-outline"></i>
								<span class="nav-text">Dashboard</span>
							</a>
							<hr>
						</li>

						

						<!-- Users -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="{{url('restaurant/delivery-boy-list')}}">
								<i class="mdi mdi-account-group"></i>
								<span class="nav-text">Delivery Boy</span> <b class="caret"></b>
							</a>
							
							<hr>
						</li>
                        <!-- Category -->


						

						<!-- Products -->
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-palette-advanced"></i>
								<span class="nav-text">Products</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="products" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('restaurant/attributes')}}">
											<span class="nav-text">Attributes List</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('restaurant/product-list')}}">
											<span class="nav-text">Product List</span>
										</a>
									</li>
								</ul>
							</div>
						</li>

						
						<li class="has-sub">
							<a class="sidenav-item-link" href="javascript:void(0)">
								<i class="mdi mdi-cart"></i>
								<span class="nav-text">Orders</span> <b class="caret"></b>
							</a>
							<div class="collapse">
								<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">
									<li class="">
										<a class="sidenav-item-link" href="{{url('restaurant/orders')}}">
											<span class="nav-text">All Order</span>
										</a>
									</li>
									<li class="">
										<a class="sidenav-item-link" href="{{url('restaurant/return-orders')}}">
											<span class="nav-text">Return Order</span>
										</a>
									</li>
								</ul>
							</div>
						</li>


						
						<!-- Orders -->
						<!--<li class="has-sub">-->
						<!--	<a class="sidenav-item-link" href="javascript:void(0)">-->
						<!--		<i class="mdi mdi-star-outline"></i>-->
						<!--		<span class="nav-text">Ratings</span> <b class="caret"></b>-->
						<!--	</a>-->
						<!--	<div class="collapse">-->
						<!--		<ul class="sub-menu" id="orders" data-parent="#sidebar-menu">-->
						<!--			<li class="">-->
						<!--				<a class="sidenav-item-link" href="{{url('restaurant/ratings')}}">-->
						<!--					<span class="nav-text">Rating & Review</span>-->
						<!--				</a>-->
						<!--			</li>-->
						<!--		</ul>-->
						<!--	</div>-->
						<!--</li>-->

					</ul>
				</div>
			</div>
		</div>