<?php
# Linux Day Torino website
# Copyright (C) 2019 Ludovico Pavesi, Valerio Bozzolan and contributors
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU Affero General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
# GNU Affero General Public License for more details.
#
# You should have received a copy of the GNU Affero General Public License
# along with this program. If not, see <http://www.gnu.org/licenses/>.

require 'load.php';

$conference = FullConference::factoryFromUID( CURRENT_CONFERENCE_UID )
	->queryRow();

$conference or die_with_404();

FORCE_PERMALINK
	and $conference->forceConferencePermalink();

template( 'header', [
	'conference' => $conference,
] );

?>
<!-- =========================
    INTRO SECTION
============================== -->
<section id="intro" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<h3>Sabato 32 Ottobre 2019</h3>
				<h1>Linux Day Torino</h1>
				<a href="#overview" class="btn btn-lg btn-default smoothScroll hidden-xs">LEARN MORE</a>
				<a href="#register" class="btn btn-lg btn-danger smoothScroll">REGISTER NOW</a>
			</div>


		</div>
	</div>
</section>


<!-- =========================
    OVERVIEW SECTION   
============================== -->
<section id="overview" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-6 col-sm-6">
				<h3>Linux Day Torino 2019 è un evento bello.</h3>
				<p>Lorem ipsum bla bla bla.</p>
				<p>Quisque facilisis scelerisque venenatis. Nam vulputate ultricies luctus. Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet.</p>
			</div>

			<div class="col-md-6 col-sm-6">
				<img src="/2019/images/placeholder-cose.png" class="img-responsive" alt="Overview">
			</div>

		</div>
	</div>
</section>


<!-- =========================
    DETAIL SECTION   
============================== -->
<section id="detail" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-4 col-sm-4">
				<i class="fa fa-group"></i>
				<h3>650 Participants</h3>
				<p>Quisque ut libero sapien. Integer tellus nisl, efficitur sed dolor at, vehicula finibus massa. Sed tincidunt metus sed eleifend suscipit.</p>
			</div>

			<div class="col-md-4 col-sm-4">
				<i class="fa fa-clock-o"></i>
				<h3>24 Programs</h3>
				<p>Quisque ut libero sapien. Integer tellus nisl, efficitur sed dolor at, vehicula finibus massa. Sed tincidunt metus sed eleifend suscipit.</p>
			</div>

			<div class="col-md-4 col-sm-4">
				<i class="fa fa-microphone"></i>
				<h3>11 Speakers</h3>
				<p>Quisque ut libero sapien. Integer tellus nisl, efficitur sed dolor at, vehicula finibus massa. Sed tincidunt metus sed eleifend suscipit.</p>
			</div>

		</div>
	</div>
</section>


<!-- =========================
    VIDEO SECTION   
============================== -->
<section id="video" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-6 col-sm-10">
				<h2>Watch Video</h2>
				<h3>Quisque ut libero sapien. Integer tellus nisl, efficitur sed dolor at, vehicula finibus massa. Sed tincidunt metus sed eleifend suscipit.</h3>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet consectetuer diam nonummy.</p>
			</div>
			<div class="col-md-6 col-sm-10">
				<div class="embed-responsive embed-responsive-16by9">
					<!-- iframe class="embed-responsive-item" src="https://www.youtube.com/embed/6sqk9MT9Tfg" allowfullscreen></iframe -->
				</div>
			</div>

		</div>
	</div>
</section>


<!-- =========================
    SPEAKERS SECTION   
============================== -->
<section id="speakers" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<div class="section-title">
					<h2>Creative Speakers</h2>
					<p>Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet.</p>
				</div>
			</div>

			<!-- Testimonial Owl Carousel section
			================================================== -->
			<div id="owl-speakers" class="owl-carousel">

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Mario Rossi</h3>
								<h6>Smanettone</h6>
							</div>
					</div>
				</div>

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Giovanna Bianchi</h3>
								<h6>Nerdona</h6>
							</div>
					</div>
				</div>

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Joe Vanni</h3>
								<h6>Tizio a caso</h6>
							</div>
					</div>
				</div>

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Mario Rossi</h3>
								<h6>Smanettone</h6>
							</div>
					</div>
				</div>

				<div class="item col-md-3 col-sm-3">
					<div class="speakers-wrapper">
						<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="speakers">
							<div class="speakers-thumb">
								<h3>Mario Rossi Rossi</h3>
								<h6>Doppio smanettone</h6>
							</div>
					</div>
				</div>
				
			</div>

		</div>
	</div>
</section>


<!-- =========================
    PROGRAM SECTION   
============================== -->
<section id="program" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<div class="section-title">
					<h2>Our Programs</h2>
					<p>Quisque ut libero sapien. Integer tellus nisl, efficitur sed dolor at, vehicula finibus massa. Sed tincidunt metus sed eleifend suscipit.</p>
				</div>
			</div>

			<div class="col-md-10 col-sm-10">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li class="active"><a href="#fday" aria-controls="fday" role="tab" data-toggle="tab">FIRST DAY</a></li>
					<li><a href="#sday" aria-controls="sday" role="tab" data-toggle="tab">SECOND DAY</a></li>
					<li><a href="#tday" aria-controls="tday" role="tab" data-toggle="tab">THIRD DAY</a></li>
				</ul>
				<!-- tab panes -->
				<div class="tab-content">

					<div role="tabpanel" class="tab-pane active" id="fday">
						<!-- program speaker here -->
						<div class="col-md-2 col-sm-2">
							<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="program">
						</div>
						<div class="col-md-10 col-sm-10">
							<h6>
								<span><i class="fa fa-clock-o"></i> 09.00 AM</span> 
								<span><i class="fa fa-map-marker"></i> Room 240</span>
							</h6>
							<h3>Introduction to Design</h3>
							<h4>By Jenny Green</h4>
							<p>Maecenas accumsan metus turpis, eu faucibus ligula interdum in. Mauris at tincidunt felis, vitae aliquam magna. Sed aliquam fringilla vestibulum.</p>
						</div>

						<!-- program divider -->
						<div class="program-divider col-md-12 col-sm-12"></div>

						<!-- program speaker here -->
						<div class="col-md-2 col-sm-2">
							<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="program">
						</div>
						<div class="col-md-10 col-sm-10">
							<h6>
								<span><i class="fa fa-clock-o"></i> 10.00 AM</span> 
								<span><i class="fa fa-map-marker"></i> Room 360</span>
							</h6>
							<h3>Front-End Development</h3>
							<h4>By Johnathan Mark</h4>
							<p>Mauris at tincidunt felis, vitae aliquam magna. Sed aliquam fringilla vestibulum. Praesent ullamcorper mauris fermentum turpis scelerisque rutrum eget eget turpis.</p>
						</div>

						<!-- program divider -->
						<div class="program-divider col-md-12 col-sm-12"></div>

						<!-- program speaker here -->
						<div class="col-md-2 col-sm-2">
							<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="program">
						</div>
						<div class="col-md-10 col-sm-10">
							<h6>
								<span><i class="fa fa-clock-o"></i> 11.00 AM</span> 
								<span><i class="fa fa-map-marker"></i> Room 450</span>
							</h6>
							<h3>Social Media Marketing</h3>
							<h4>By Johnathan Doe</h4>
							<p>Nam pulvinar, elit vitae rhoncus pretium, massa urna bibendum ex, aliquam efficitur lorem odio vitae erat. Integer rutrum viverra magna, nec ultrices risus rutrum nec.</p>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="sday">
						<!-- program speaker here -->
						<div class="col-md-2 col-sm-2">
							<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="program">
						</div>
						<div class="col-md-10 col-sm-10">
							<h6>
								<span><i class="fa fa-clock-o"></i> 11.00 AM</span> 
								<span><i class="fa fa-map-marker"></i> Room 240</span>
							</h6>
							<h3>Backend Development</h3>
							<h4>By Matt Lee</h4>
							<p>Integer rutrum viverra magna, nec ultrices risus rutrum nec. Pellentesque interdum vel nisi nec tincidunt. Quisque facilisis scelerisque venenatis. Nam vulputate ultricies luctus.</p>
						</div>

						<!-- program divider -->
						<div class="program-divider col-md-12 col-sm-12"></div>

						<!-- program speaker here -->
						<div class="col-md-2 col-sm-2">
							<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="program">
						</div>
						<div class="col-md-10 col-sm-10">
							<h6>
								<span><i class="fa fa-clock-o"></i> 01.00 PM</span> 
								<span><i class="fa fa-map-marker"></i> Room 450</span>
							</h6>
							<h3>Web Application Lite</h3>
							<h4>By David Orlando</h4>
							<p>Aliquam faucibus lobortis dolor, id pellentesque eros pretium in. Aenean in erat ut quam aliquet commodo. Vivamus aliquam pulvinar ipsum ut sollicitudin. Suspendisse quis sollicitudin mauris.</p>
						</div>

						<!-- program divider -->
						<div class="program-divider col-md-12 col-sm-12"></div>

						<!-- program speaker here -->
						<div class="col-md-2 col-sm-2">
							<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="program">
						</div>
						<div class="col-md-10 col-sm-10">
							<h6>
								<span><i class="fa fa-clock-o"></i> 03.00 PM</span> 
								<span><i class="fa fa-map-marker"></i> Room 650</span>
							</h6>
							<h3>Professional UX Design</h3>
							<h4>By James Lee Mark</h4>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat.</p>
						</div>
					</div>

					<div role="tabpanel" class="tab-pane" id="tday">
						<!-- program speaker here -->
						<div class="col-md-2 col-sm-2">
							<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="program">
						</div>
						<div class="col-md-10 col-sm-10">
							<h6>
								<span><i class="fa fa-clock-o"></i> 03.00 PM</span> 
								<span><i class="fa fa-map-marker"></i> Room 750</span>
							</h6>
							<h3>Online Shopping Business</h3>
							<h4>By Michael Walker</h4>
							<p>Aliquam faucibus lobortis dolor, id pellentesque eros pretium in. Aenean in erat ut quam aliquet commodo. Vivamus aliquam pulvinar ipsum ut sollicitudin. Suspendisse quis sollicitudin mauris.</p>
						</div>

						<!-- program divider -->
						<div class="program-divider col-md-12 col-sm-12"></div>

						<!-- program speaker here -->
						<div class="col-md-2 col-sm-2">
							<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="program">
						</div>
						<div class="col-md-10 col-sm-10">
							<h6>
								<span><i class="fa fa-clock-o"></i> 05.00 PM</span> 
								<span><i class="fa fa-map-marker"></i> Room 850</span>
							</h6>
							<h3>Introduction to Mobile App</h3>
							<h4>By Cherry Stella</h4>
							<p>Nunc eu nibh vel augue mollis tincidunt id efficitur tortor. Sed pulvinar est sit amet tellus iaculis hendrerit. Mauris justo erat, rhoncus in arcu at, scelerisque tempor erat.</p>
						</div>

						<!-- program divider -->
						<div class="program-divider col-md-12 col-sm-12"></div>

						<!-- program speaker here -->
						<div class="col-md-2 col-sm-2">
							<img src="/2019/images/placeholder-person.png" class="img-responsive" alt="program">
						</div>
						<div class="col-md-10 col-sm-10">
							<h6>
								<span><i class="fa fa-clock-o"></i> 07.00 PM</span> 
								<span><i class="fa fa-map-marker"></i> Room 750</span>
							</h6>
							<h3>Bootstrap UI Design</h3>
							<h4>By John David</h4>
							<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat.</p>
						</div>
					</div>

				</div>

		</div>
	</div>
</section>


<!-- =========================
   REGISTER SECTION   
============================== -->
<section id="register" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-7 col-sm-7">
				<h2>Register Here</h2>
				<h3>Nunc eu nibh vel augue mollis tincidunt id efficitur tortor. Sed pulvinar est sit amet tellus iaculis hendrerit.</h3>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat. Lorem ipsum dolor sit amet consectetuer diam nonummy.</p>
			</div>

			<div class="col-md-5 col-sm-5">
				<form action="#" method="post">
					<input name="firstname" type="text" class="form-control" id="firstname" placeholder="First Name">
					<input name="lastname" type="text" class="form-control" id="lastname" placeholder="Last Name">
					<input name="phone" type="telephone" class="form-control" id="phone" placeholder="Phone Number">
					<input name="email" type="email" class="form-control" id="email" placeholder="Email Address">
					<div class="col-md-offset-6 col-md-6 col-sm-offset-1 col-sm-10">
						<input name="submit" type="submit" class="form-control" id="submit" value="REGISTER">
					</div>
				</form>
			</div>

			<div class="col-md-1"></div>

		</div>
	</div>
</section>


<!-- =========================
    FAQ SECTION   
============================== -->
<section id="faq" class="parallax-section">
	<div class="container">
		<div class="row">

			<!-- Section title
			================================================== -->
			<div class="col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10 text-center">
				<div class="section-title">
					<h2>Do you have Questions?</h2>
					<p>Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet.</p>
				</div>
			</div>

			<div class="col-md-offset-1 col-md-10 col-sm-offset-1 col-sm-10">
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

  					<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingOne">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          							 What is Responsive Design?
        						</a>
      						</h4>
    					</div>
   						<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      						<div class="panel-body">
        						<p>Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet, wisi risus purus augue vulputate voluptate neque, curabitur dolor libero sodales vitae elit massa. Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet.</p>
								<p>Nunc eu nibh vel augue mollis tincidunt id efficitur tortor. Sed pulvinar est sit amet tellus iaculis hendrerit. Mauris justo erat, rhoncus in arcu at, scelerisque tempor erat.</p>
      						</div>
   						 </div>
 					</div>

    				<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingTwo">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          							What are latest UX Developments?
        						</a>
      						</h4>
    					</div>
   						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      						<div class="panel-body">
                            	<p>Nunc eu nibh vel augue mollis tincidunt id efficitur tortor. Sed pulvinar est sit amet tellus iaculis hendrerit. Mauris justo erat, rhoncus in arcu at, scelerisque tempor erat.</p>
        						<p>Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet, wisi risus purus augue vulputate voluptate neque, curabitur dolor libero sodales vitae elit massa. Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet.</p>
      						</div>
   						 </div>
 					</div>

 					<div class="panel panel-default">
   						<div class="panel-heading" role="tab" id="headingThree">
      						<h4 class="panel-title">
        						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          							What things about Social Media will be discussed?
        						</a>
      						</h4>
    					</div>
   						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      						<div class="panel-body">
                            	<p>Aenean vulputate finibus justo et feugiat. Ut turpis lacus, dapibus quis justo id, porttitor tempor justo. Quisque ut libero sapien. Integer tellus nisl, efficitur sed dolor at, vehicula finibus massa.</p>
        						<p>Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet, wisi risus purus augue vulputate voluptate neque, curabitur dolor libero sodales vitae elit massa. Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet.</p>
      						</div>
   						 </div>
 					 </div>

 				 </div>
			</div>

		</div>
	</div>
</section>


<!-- =========================
    VENUE SECTION   
============================== -->
<section id="venue" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-offset-1 col-md-5 col-sm-8">
				<h2>Venue</h2>
				<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat.</p>
				<h4>New Event</h4>
  				<h4>120 Market Street, Suite 110</h4>
  				<h4>San Francisco, CA 10110</h4>
				<h4>Tel: 010-020-0120</h4>		
			</div>

		</div>
	</div>
</section>


<!-- =========================
    SPONSORS SECTION   
============================== -->
<section id="sponsors" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-12 col-sm-12">
				<div class="section-title">
					<h2>Our Sponsors</h2>
					<p>Lorem ipsum dolor sit amet, maecenas eget vestibulum justo imperdiet.</p>
				</div>
			</div>

			<div class="col-md-3 col-sm-6 col-xs-6">
				<img src="images/sponsor-img1.jpg" class="img-responsive" alt="sponsors">	
			</div>

			<div class="col-md-3 col-sm-6 col-xs-6">
				<img src="images/sponsor-img2.jpg" class="img-responsive" alt="sponsors">	
			</div>

			<div class="col-md-3 col-sm-6 col-xs-6">
				<img src="images/sponsor-img3.jpg" class="img-responsive" alt="sponsors">	
			</div>

			<div class="col-md-3 col-sm-6 col-xs-6">
				<img src="images/sponsor-img4.jpg" class="img-responsive" alt="sponsors">	
			</div>

		</div>
	</div>
</section>


<!-- =========================
    CONTACT SECTION   
============================== -->
<section id="contact" class="parallax-section">
	<div class="container">
		<div class="row">

			<div class="col-md-offset-1 col-md-5 col-sm-6">
				<div class="contact_des">
					<h3>New Event</h3>
					<p>Proin sodales convallis urna eu condimentum. Morbi tincidunt augue eros, vitae pretium mi condimentum eget. Suspendisse eu turpis sed elit pretium congue.</p>
					<p>Mauris at tincidunt felis, vitae aliquam magna. Sed aliquam fringilla vestibulum. Praesent ullamcorper mauris fermentum turpis scelerisque rutrum eget eget turpis.</p>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet. Dolore magna aliquam erat volutpat. Lorem ipsum dolor.</p>
					<a href="#" class="btn btn-danger">DOWNLOAD NOW</a>
				</div>
			</div>

			<div class="col-md-5 col-sm-6">
				<div class="contact_detail">
					<div class="section-title">
						<h2>Keep in touch</h2>
					</div>
					<form action="#" method="post">
						<input name="name" type="text" class="form-control" id="name" placeholder="Name">
					  	<input name="email" type="email" class="form-control" id="email" placeholder="Email">
					  	<textarea name="message" rows="5" class="form-control" id="message" placeholder="Message"></textarea>
						<div class="col-md-6 col-sm-10">
							<input name="submit" type="submit" class="form-control" id="submit" value="SEND">
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</section>
<?php template( 'footer' );