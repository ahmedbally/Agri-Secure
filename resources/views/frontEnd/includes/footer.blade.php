<!-- FOOTER -->
<footer>
   <div class="bggray" >

		<div class="container">
			<div class="row">
				<?php $about = App\Topic::find(1);?>
				@if($about)
				<div class="col-md-4 col-sm-12">
					<h6 class="footer-title"><span>عن</span> القطاع</h6>
					<div class="footer-div">
						{{ strip_tags($about->details_ar) }}
					</div>
				</div>
				@endif


				<div class="col-md-4 col-sm-12">

				   <h6 class="footer-title"> <span>اتصل </span> بنا</h6>

				   <div class="footer-div">

					  <p>
						<span class="fa fa-phone"></span>
						<b>هاتف:</b> {{ Helper::GeneralSiteSettings("contact_t3") }}
					  </p>
					  <p>
						<span class="fa fa-fax"></span>
						<b>فاكس:</b> {{ Helper::GeneralSiteSettings("contact_t4") }}
					  </p>
					   <p>
						<span class="fa fa-envelope"></span>
						<b>بريد:</b> {{ Helper::GeneralSiteSettings("contact_t6") }}
					  </p>
					   <p>
						<span class="fa fa-map-marker"></span>
						<b>عنوان:</b> {{ Helper::GeneralSiteSettings("contact_t1_ar") }}
					  </p>
				   </div>

				</div>

				<?php $contactMap = App\Map::where('topic_id',2)->first(); ?>
				@if($contactMap)

				<div class="col-md-4 col-sm-12">
					<h6 class="footer-title"> <span>موقعنا</span> الجغرافي</h6>
					<div class="footer-div">
						<iframe scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com.eg/maps?sll={{$contactMap->longitude}},{{$contactMap->latitude}}&amp;sspn={{$contactMap->longitude}},{{$contactMap->latitude}}&amp;cid=0&amp;q={{$contactMap->longitude}},{{$contactMap->latitude}}&amp;ie=UTF8&amp;t=m&amp;ll={{$contactMap->longitude}},{{$contactMap->latitude}}&amp;spn=0.006295,0.006295&amp;output=embed" width="100%" height="200" frameborder="0"></iframe>
					</div>
				</div>
				@endif

			</div>
		</div>

	</div>
    <div class="footer-bottom">
        <div class="footer-linck">
			<a href="{{url('/')}}">{{trans('frontLang.home')}}</a>
			<a href="{{url('map')}}">الخريطة المحصولية</a>
			<!-- <a href="#">احصاءات</a> -->
			<a href="{{url('news')}}">{{trans('backLang.news')}} </a>
			<a href="{{url('organize')}}">{{trans('backLang.OrganizationalStructure')}} </a>
			<!-- <a href="#">نشرات زراعية</a> -->
            <a href="{{url('events')}}">{{trans('backLang.events')}} </a>
			<a href="{{url('polls')}}">شارك برأيك</a>
			<a href="{{url('sites')}}">{{trans('frontLang.sites')}}</a>
			<a href="{{url('/contact')}}">{{trans('frontLang.contactUs')}}</a>
        </div>
        <div class="media-icon">
            <a href="#"><img src="{{ URL::asset('frontEnd/img/icons/c-icon.png')}}" alt=""/></a>
            <a href="#"><img src="{{ URL::asset('frontEnd/img/icons/c-icon3.png')}}" alt=""/></a>
			<a href="#"><img src="{{ URL::asset('frontEnd/img/icons/c-icon4.png')}}" alt=""/></a>
        </div>
        <div class="copy">
            <span> جميع الحقوق محفوظة لقطاع الشئون الاقتصادية © {{date('Y')}} </span>
        </div>
    </div>
    <div class="back-to-top"><i class="fa fa-chevron-up"></i></div>
</footer>








<!-- Modal -->
<div id="searchModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bgmdlgry">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">بحث في الموقع</h5>
      </div>
      <div class="modal-body p30">
		<form action="/search">
			<div class="input-group">
				<input type="text" name="q" class="form-control" placeholder="ابحث هنا ...">
				<div class="input-group-btn">
				<button class="btn btn-default bg-green" type="submit">
					<i class="glyphicon glyphicon-search"></i>
				</button>
				</div>
			</div>
		</form>
      </div>
    </div>
  </div>
</div>



<div id="gehatModal" class="modal fade text-center" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bgmdlgry">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">الجهات المشاركة</h5>
      </div>
      <div class="modal-body p30">
		<table class="table table-striped">
			<tbody>
				<tr>
					<td><a href="#">مركز الزراعات التعاقدية</a></td>
				</tr>
				<tr>
					<td><a href="#">المعمل المركزى لتحليل متبقيات المبيدات</a></td>
				</tr>
				<tr>
					<td><a href="#">الحجر الزراعى</a></td>
				</tr>
				<tr>
					<td><a href="#">الأمصال</a></td>
				</tr>
				<tr>
					<td><a href="#">المركز الاقليمى</a></td>
				</tr>
				<tr>
					<td><a href="#">وحدة الفاقد والتالف بمعهد بحوث الاقتصاد الزراعى</a></td>
				</tr>
				<tr>
					<td><a href="#">الإتحادات التعاونية</a></td>
				</tr>
				<tr>
					<td><a href="#">جمعيات المزارعين</a></td>
				</tr>
			</tbody>
		</table>
      </div>
    </div>
  </div>
</div>
