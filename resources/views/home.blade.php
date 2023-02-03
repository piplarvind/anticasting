@extends('layouts.master')
@section('content')

<script>
    @if(Session::has('message'))
       toastr.success("{{ Session::get('message') }}");
     @endif
 </script>
 <!-- ======= Hero Section ======= -->
 
 <section  id="hero" class="hero d-flex align-items-center" style="background-image: url('https://anticasting.in/wp-content/uploads/2022/05/Slide2-2.jpg'); 
 background-size: cover; height:400px;">
 
  <div class="container">
   
    <div class="row gy-4 d-flex justify-content-between">
      <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
        <h2 data-aos="fade-up">Your Lightning Fast Delivery Partner</h2>
        <p data-aos="fade-up" data-aos-delay="100">Facere distinctio molestiae nisi fugit tenetur repellat non praesentium nesciunt optio quis sit odio nemo quisquam. eius quos reiciendis eum vel eum voluptatem eum maiores eaque id optio ullam occaecati odio est possimus vel reprehenderit</p>


        
        
    

        <div class="row gy-4" data-aos="fade-up" data-aos-delay="400">

          <div class="col-lg-3 col-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="232" data-purecounter-duration="1" class="purecounter"></span>
              <p>Clients</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="521" data-purecounter-duration="1" class="purecounter"></span>
              <p>Projects</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="1453" data-purecounter-duration="1" class="purecounter"></span>
              <p>Support</p>
            </div>
          </div><!-- End Stats Item -->

          <div class="col-lg-3 col-6">
            <div class="stats-item text-center w-100 h-100">
              <span data-purecounter-start="0" data-purecounter-end="32" data-purecounter-duration="1" class="purecounter"></span>
              <p>Workers</p>
            </div>
          </div><!-- End Stats Item -->

        </div>
      </div>

      <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
        <img src="assets/img/hero-img.svg" class="img-fluid mb-3 mb-lg-0" alt="">
      </div>

    </div>
  </div>
</section><!-- End Hero Section -->
 <!-- ======= About Us Section ======= -->
 <section id="about" class="about">
  <div class="container" data-aos="fade-up">

    <div class="row gy-4">
      <div class="col-lg-6 position-relative align-self-start order-lg-last order-first">
        <img src="{{ asset('assets/users/assets/img/about.jpg')}}" class="img-fluid" alt="">
        <a href="https://www.youtube.com/watch?v=LXb3EKWsInQ" class="glightbox play-btn"></a>
      </div>
      <div class="col-lg-6 content order-last  order-lg-first">
        <h3>About Us</h3>
        <p>
          Dolor iure expedita id fuga asperiores qui sunt consequatur minima. Quidem voluptas deleniti. Sit quia molestiae quia quas qui magnam itaque veritatis dolores. Corrupti totam ut eius incidunt reiciendis veritatis asperiores placeat.
        </p>
        <ul>
          <li data-aos="fade-up" data-aos-delay="100">
            <i class="bi bi-diagram-3"></i>
            <div>
              <h5>Ullamco laboris nisi ut aliquip consequat</h5>
              <p>Magni facilis facilis repellendus cum excepturi quaerat praesentium libre trade</p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="200">
            <i class="bi bi-fullscreen-exit"></i>
            <div>
              <h5>Magnam soluta odio exercitationem reprehenderi</h5>
              <p>Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata redi</p>
            </div>
          </li>
          <li data-aos="fade-up" data-aos-delay="300">
            <i class="bi bi-broadcast"></i>
            <div>
              <h5>Voluptatem et qui exercitationem</h5>
              <p>Et velit et eos maiores est tempora et quos dolorem autem tempora incidunt maxime veniam</p>
            </div>
          </li>
        </ul>
      </div>
    </div>

  </div>
</section><!-- End About Us Section -->
<div class="breadcrumbs">
  <div class="page-header d-flex align-items-center" style="background-image: url('assets/users/assets/img/page-header.jpg');">
      <div class="container position-relative">
          <div class="row d-flex justify-content-center">
              <div class="col-lg-6 text-center">
                  <h2>Contact</h2>
                  <p>Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint voluptas
                      consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores. Quasi ratione
                      sint. Sit quaerat ipsum dolorem.</p>
                      <div class="mt-3">
                        <a class=" me-5 hover-shadow hover-overlay btn btn-primary " >
                        
                          Submit Profile
                          <i class="fa fa-arrow-right"></i>
                        </a>
                        <a   class=" hover-shadow hover-overlay btn btn-primary" >Work With Us
                          <i class="fa fa-arrow-right"></i>
                        </a>
                      </div>
              </div>
          </div>
      </div>
  </div>

</div><!-- End Breadcrumbs -->
 

@endsection
   