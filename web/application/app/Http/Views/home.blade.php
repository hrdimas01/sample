@extends('layout')
@section('content')

<div class="m-grid__item m-grid__item--fluid m-wrapper">
	<!-- BEGIN: Subheader -->
	<div class="m-subheader ">
		<div class="d-flex align-items-center">
			<div class="mr-auto">
				<h3 class="m-subheader__title ">
					Dashboard
				</h3>
			</div>
			<div>
				<span class="m-subheader__daterange" id="m_dashboard_daterangepicker">
					<span class="m-subheader__daterange-label">
						<span class="m-subheader__daterange-title"></span>
						<span class="m-subheader__daterange-date m--font-brand"></span>
					</span>
					<a href="#" class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill">
						<i class="la la-angle-down"></i>
					</a>
				</span>
			</div>
		</div>
	</div>
	<!-- END: Subheader -->
	<div class="m-content">
		<!--Begin::Section-->
		<div class="row">
			<div class="col-xl-4">
				<!--begin:: Widgets/Top Products-->
				<div class="m-portlet m-portlet--bordered-semi m-portlet--full-height ">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text">
									Trends
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
								<li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover" aria-expanded="true">
									<a href="#" class="m-portlet__nav-link m-dropdown__toggle dropdown-toggle btn btn--sm m-btn--pill btn-secondary m-btn m-btn--label-brand">
										All
									</a>
									<div class="m-dropdown__wrapper">
										<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust" style="left: auto; right: 36.5px;"></span>
										<div class="m-dropdown__inner">
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="m-nav">
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-share"></i>
																<span class="m-nav__link-text">
																	Activity
																</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-chat-1"></i>
																<span class="m-nav__link-text">
																	Messages
																</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-info"></i>
																<span class="m-nav__link-text">
																	FAQ
																</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																<span class="m-nav__link-text">
																	Support
																</span>
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<!--begin::Widget5-->
						<div class="m-widget4">
							<div class="m-widget4__chart m-portlet-fit--sides m--margin-top-10 m--margin-top-20" style="height:260px;">
								<canvas id="m_chart_trends_stats"></canvas>
							</div>
							<div class="m-widget4__item">
								<div class="m-widget4__img m-widget4__img--logo">
									<img src="{{aset_tema('', 'metronic-5.5.5')}}app/media/img/client-logos/logo3.png" alt="">
								</div>
								<div class="m-widget4__info">
									<span class="m-widget4__title">
										Phyton
									</span>
									<br>
									<span class="m-widget4__sub">
										A Programming Language
									</span>
								</div>
								<span class="m-widget4__ext">
									<span class="m-widget4__number m--font-danger">
										+$17
									</span>
								</span>
							</div>
							<div class="m-widget4__item">
								<div class="m-widget4__img m-widget4__img--logo">
									<img src="{{aset_tema('', 'metronic-5.5.5')}}app/media/img/client-logos/logo1.png" alt="">
								</div>
								<div class="m-widget4__info">
									<span class="m-widget4__title">
										FlyThemes
									</span>
									<br>
									<span class="m-widget4__sub">
										A Let's Fly Fast Again Language
									</span>
								</div>
								<span class="m-widget4__ext">
									<span class="m-widget4__number m--font-danger">
										+$300
									</span>
								</span>
							</div>
							<div class="m-widget4__item">
								<div class="m-widget4__img m-widget4__img--logo">
									<img src="{{aset_tema('', 'metronic-5.5.5')}}app/media/img/client-logos/logo2.png" alt="">
								</div>
								<div class="m-widget4__info">
									<span class="m-widget4__title">
										AirApp
									</span>
									<br>
									<span class="m-widget4__sub">
										Awesome App For Project Management
									</span>
								</div>
								<span class="m-widget4__ext">
									<span class="m-widget4__number m--font-danger">
										+$6700
									</span>
								</span>
							</div>
						</div>
						<!--end::Widget 5-->
					</div>
				</div>
				<!--end:: Widgets/Top Products-->
			</div>
			<div class="col-xl-4">
				<!--begin:: Widgets/Activity-->
				<div class="m-portlet m-portlet--bordered-semi m-portlet--widget-fit m-portlet--full-height m-portlet--skin-light  m-portlet--rounded-force">
					<div class="m-portlet__head">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-title">
								<h3 class="m-portlet__head-text m--font-light">
									Activity
								</h3>
							</div>
						</div>
						<div class="m-portlet__head-tools">
							<ul class="m-portlet__nav">
								<li class="m-portlet__nav-item m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push" data-dropdown-toggle="hover">
									<a href="#" class="m-portlet__nav-link m-portlet__nav-link--icon m-portlet__nav-link--icon-xl">
										<i class="fa fa-genderless m--font-light"></i>
									</a>
									<div class="m-dropdown__wrapper">
										<span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
										<div class="m-dropdown__inner">
											<div class="m-dropdown__body">
												<div class="m-dropdown__content">
													<ul class="m-nav">
														<li class="m-nav__section m-nav__section--first">
															<span class="m-nav__section-text">
																Quick Actions
															</span>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-share"></i>
																<span class="m-nav__link-text">
																	Activity
																</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-chat-1"></i>
																<span class="m-nav__link-text">
																	Messages
																</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-info"></i>
																<span class="m-nav__link-text">
																	FAQ
																</span>
															</a>
														</li>
														<li class="m-nav__item">
															<a href="" class="m-nav__link">
																<i class="m-nav__link-icon flaticon-lifebuoy"></i>
																<span class="m-nav__link-text">
																	Support
																</span>
															</a>
														</li>
														<li class="m-nav__separator m-nav__separator--fit"></li>
														<li class="m-nav__item">
															<a href="#" class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
																Cancel
															</a>
														</li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-widget17">
							<div class="m-widget17__visual m-widget17__visual--chart m-portlet-fit--top m-portlet-fit--sides m--bg-danger">
								<div class="m-widget17__chart" style="height:320px;">
									<canvas id="m_chart_activities"></canvas>
								</div>
							</div>
							<div class="m-widget17__stats">
								<div class="m-widget17__items m-widget17__items-col1">
									<div class="m-widget17__item">
										<span class="m-widget17__icon">
											<i class="flaticon-truck m--font-brand"></i>
										</span>
										<span class="m-widget17__subtitle">
											Delivered
										</span>
										<span class="m-widget17__desc">
											15 New Paskages
										</span>
									</div>
									<div class="m-widget17__item">
										<span class="m-widget17__icon">
											<i class="flaticon-paper-plane m--font-info"></i>
										</span>
										<span class="m-widget17__subtitle">
											Reporeted
										</span>
										<span class="m-widget17__desc">
											72 Support Cases
										</span>
									</div>
								</div>
								<div class="m-widget17__items m-widget17__items-col2">
									<div class="m-widget17__item">
										<span class="m-widget17__icon">
											<i class="flaticon-pie-chart m--font-success"></i>
										</span>
										<span class="m-widget17__subtitle">
											Ordered
										</span>
										<span class="m-widget17__desc">
											72 New Items
										</span>
									</div>
									<div class="m-widget17__item">
										<span class="m-widget17__icon">
											<i class="flaticon-time m--font-danger"></i>
										</span>
										<span class="m-widget17__subtitle">
											Arrived
										</span>
										<span class="m-widget17__desc">
											34 Upgraded Boxes
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--end:: Widgets/Activity-->
			</div>
			<div class="col-xl-4">
				<!--begin:: Widgets/Blog-->
				<div class="m-portlet m-portlet--bordered-semi m-portlet--full-height  m-portlet--rounded-force">
					<div class="m-portlet__head m-portlet__head--fit">
						<div class="m-portlet__head-caption">
							<div class="m-portlet__head-action">
								<button type="button" class="btn btn-sm m-btn--pill  btn-brand">
									Blog
								</button>
							</div>
						</div>
					</div>
					<div class="m-portlet__body">
						<div class="m-widget19">
							<div class="m-widget19__pic m-portlet-fit--top m-portlet-fit--sides" style="min-height-: 286px">
								<img src="{{aset_tema('', 'metronic-5.5.5')}}app/media/img//blog/blog1.jpg" alt="">
								<h3 class="m-widget19__title m--font-light">
									Introducing New Feature
								</h3>
								<div class="m-widget19__shadow"></div>
							</div>
							<div class="m-widget19__content">
								<div class="m-widget19__header">
									<div class="m-widget19__user-img">
										<img class="m-widget19__img" src="{{aset_tema('', 'metronic-5.5.5')}}app/media/img//users/user1.jpg" alt="">
									</div>
									<div class="m-widget19__info">
										<span class="m-widget19__username">
											Anna Krox
										</span>
										<br>
										<span class="m-widget19__time">
											UX/UI Designer, Google
										</span>
									</div>
									<div class="m-widget19__stats">
										<span class="m-widget19__number m--font-brand">
											18
										</span>
										<span class="m-widget19__comment">
											Comments
										</span>
									</div>
								</div>
								<div class="m-widget19__body">
									Lorem Ipsum is simply dummy text of the printing and typesetting industry scrambled it to make text of the printing and typesetting industry scrambled a type specimen book text of the dummy text of the printing printing and typesetting industry scrambled dummy text of the printing.
								</div>
							</div>
							<div class="m-widget19__action">
								<button type="button" class="btn m-btn--pill btn-secondary m-btn m-btn--hover-brand m-btn--custom">
									Read More
								</button>
							</div>
						</div>
					</div>
				</div>
				<!--end:: Widgets/Blog-->
			</div>
		</div>
		<!--End::Section-->
		<!--Begin::Section-->
		<div class="m-portlet">
			<div class="m-portlet__body  m-portlet__body--no-padding">
				<div class="row m-row--no-padding m-row--col-separator-xl">
					<div class="col-xl-4">
						<!--begin:: Widgets/Stats2-1 -->
						<div class="m-widget1">
							<div class="m-widget1__item">
								<div class="row m-row--no-padding align-items-center">
									<div class="col">
										<h3 class="m-widget1__title">
											Member Profit
										</h3>
										<span class="m-widget1__desc">
											Awerage Weekly Profit
										</span>
									</div>
									<div class="col m--align-right">
										<span class="m-widget1__number m--font-brand">
											+$17,800
										</span>
									</div>
								</div>
							</div>
							<div class="m-widget1__item">
								<div class="row m-row--no-padding align-items-center">
									<div class="col">
										<h3 class="m-widget1__title">
											Orders
										</h3>
										<span class="m-widget1__desc">
											Weekly Customer Orders
										</span>
									</div>
									<div class="col m--align-right">
										<span class="m-widget1__number m--font-danger">
											+1,800
										</span>
									</div>
								</div>
							</div>
							<div class="m-widget1__item">
								<div class="row m-row--no-padding align-items-center">
									<div class="col">
										<h3 class="m-widget1__title">
											Issue Reports
										</h3>
										<span class="m-widget1__desc">
											System bugs and issues
										</span>
									</div>
									<div class="col m--align-right">
										<span class="m-widget1__number m--font-success">
											-27,49%
										</span>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Widgets/Stats2-1 -->
					</div>
					<div class="col-xl-4">
						<!--begin:: Widgets/Daily Sales-->
						<div class="m-widget14">
							<div class="m-widget14__header m--margin-bottom-30">
								<h3 class="m-widget14__title">
									Daily Sales
								</h3>
								<span class="m-widget14__desc">
									Check out each collumn for more details
								</span>
							</div>
							<div class="m-widget14__chart" style="height:120px;">
								<canvas  id="m_chart_daily_sales"></canvas>
							</div>
						</div>
						<!--end:: Widgets/Daily Sales-->
					</div>
					<div class="col-xl-4">
						<!--begin:: Widgets/Profit Share-->
						<div class="m-widget14">
							<div class="m-widget14__header">
								<h3 class="m-widget14__title">
									Profit Share
								</h3>
								<span class="m-widget14__desc">
									Profit Share between customers
								</span>
							</div>
							<div class="row  align-items-center">
								<div class="col">
									<div id="m_chart_profit_share" class="m-widget14__chart" style="height: 160px">
										<div class="m-widget14__stat">
											45
										</div>
									</div>
								</div>
								<div class="col">
									<div class="m-widget14__legends">
										<div class="m-widget14__legend">
											<span class="m-widget14__legend-bullet m--bg-accent"></span>
											<span class="m-widget14__legend-text">
												37% Sport Tickets
											</span>
										</div>
										<div class="m-widget14__legend">
											<span class="m-widget14__legend-bullet m--bg-warning"></span>
											<span class="m-widget14__legend-text">
												47% Business Events
											</span>
										</div>
										<div class="m-widget14__legend">
											<span class="m-widget14__legend-bullet m--bg-brand"></span>
											<span class="m-widget14__legend-text">
												19% Others
											</span>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!--end:: Widgets/Profit Share-->
					</div>
				</div>
			</div>
		</div>
		<!--End::Section-->
	</div>
</div>

<script type="text/javascript">
	setMenu('#menu-home');
</script>

@endsection()