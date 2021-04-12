@extends('web.layout')
@section('content')
<!-- End Header Content -->

  <!-- NOTIFICATION CONTENT -->
  
  <!-- END NOTIFICATION CONTENT -->

  <!-- Carousel Content -->
  <?php  echo $final_theme['carousel']; ?>
  <!-- Fixed Carousel Content -->

  <!-- Banners Content -->
  <!-- Products content -->

  <?php

  $product_section_orders = json_decode($final_theme['product_section_order'], true);
  foreach ($product_section_orders as $product_section_order){
    if($product_section_order['order'] == 1 && $product_section_order['status'] == 1){
      $r =   'web.product-sections.' . $product_section_order['file_name'];
    ?>
      @include($r)
    <?php
    }
    if($product_section_order['order'] == 2 && $product_section_order['status'] == 1){
      $r =   'web.product-sections.' . $product_section_order['file_name'];
    ?>
      @include($r)
    <?php
    }
    if($product_section_order['order'] == 3 && $product_section_order['status'] == 1){
    $r =   'web.product-sections.' . $product_section_order['file_name'];
    ?>
      @include($r)
    <?php
    }
    if($product_section_order['order'] == 4 && $product_section_order['status'] == 1){
    $r =   'web.product-sections.' . $product_section_order['file_name'];
      ?>
      @include($r)
    <?php
      }
    if($product_section_order['order'] == 5 && $product_section_order['status'] == 1){
        $r =   'web.product-sections.' . $product_section_order['file_name'];
    ?>
        @include($r)
    <?php
    }
    if($product_section_order['order'] == 6 && $product_section_order['status'] == 1){
      $r =   'web.product-sections.' . $product_section_order['file_name'];
    ?>
      @include($r)
    <?php
      }
      if($product_section_order['order'] == 7 && $product_section_order['status'] == 1){
      $r =   'web.product-sections.' . $product_section_order['file_name'];
    ?>
      @include($r)
    <?php
      }
      if($product_section_order['order'] == 8 && $product_section_order['status'] == 1){
      $r =   'web.product-sections.' . $product_section_order['file_name'];
    ?>
      @include($r)
    <?php
      }
      if($product_section_order['order'] == 9 && $product_section_order['status'] == 1){
      $r =   'web.product-sections.' . $product_section_order['file_name'];
    ?>
      @include($r)
    <?php
      }
      if($product_section_order['order'] == 10 && $product_section_order['status'] == 1){
      $r =   'web.product-sections.' . $product_section_order['file_name'];
    ?>
      @include($r)  
    <?php
      }
      if($product_section_order['order'] == 11 && $product_section_order['status'] == 1){
        $r =   'web.product-sections.' . $product_section_order['file_name'];
      ?>
        @include($r)
      <?php
        }
        if($product_section_order['order'] == 12 && $product_section_order['status'] == 1){
        $r =   'web.product-sections.' . $product_section_order['file_name'];
      ?>
        @include($r)
      <?php
        }

        if($product_section_order['order'] == 13 && $product_section_order['status'] == 1){
        $r =   'web.product-sections.' . $product_section_order['file_name'];
      ?>
        <!--@include($r)-->
      <?php
        }
    }
  ?>
  <br><br>
  <!--<div class="bg_gray " style="direction: ltr;">-->
  <!--  <div class="container margin_30">-->
  <!--    <div id="brands" class="owl-carousel owl-theme">-->
  <!--      <div class="item">-->
  <!--        <a href="#0"><img src="{{asset('images/img/brands/placeholder_brands.png')}}" data-src="{{asset('images/img/brands/logo_1.png')}}" alt=""-->
  <!--            class="owl-lazy"></a>-->
  <!--      </div>-->
  <!--      <div class="item">-->
  <!--        <a href="#0"><img src="{{asset('images/img/brands/placeholder_brands.png')}}" data-src="{{asset('images/img/brands/logo_2.png')}}" alt=""-->
  <!--            class="owl-lazy"></a>-->
  <!--      </div>-->
  <!--      <div class="item">-->
  <!--        <a href="#0"><img src="{{asset('images/img/brands/placeholder_brands.png')}}" data-src="{{asset('images/img/brands/logo_3.png')}}" alt=""-->
  <!--            class="owl-lazy"></a>-->
  <!--      </div>-->
  <!--      <div class="item">-->
  <!--        <a href="#0"><img src="{{asset('images/img/brands/placeholder_brands.png')}}" data-src="{{asset('images/img/brands/logo_4.png')}}" alt=""-->
  <!--            class="owl-lazy"></a>-->
  <!--      </div>-->
  <!--      <div class="item">-->
  <!--        <a href="#0"><img src="{{asset('images/img/brands/placeholder_brands.png')}}" data-src="{{asset('images/img/brands/logo_5.png')}}" alt=""-->
  <!--            class="owl-lazy"></a>-->
  <!--      </div>-->
  <!--      <div class="item">-->
  <!--        <a href="#0"><img src="{{asset('images/img/brands/placeholder_brands.png')}}" data-src="{{asset('images/img/brands/logo_6.png')}}" alt=""-->
  <!--            class="owl-lazy"></a>-->
  <!--      </div>-->
  <!--    </div>-->
  <!--  </div>-->
  <!--</div>-->


  <!--<div class="container margin_60_35">-->
  <!--  <div class="main_title">-->
  <!--    <h2>Latest News</h2>-->
  <!--    <span>Blog</span>-->
  <!--    <p>Cum doctus civibus efficiantur in imperdiet deterruisset</p>-->
  <!--  </div>-->
  <!--  <div class="row">-->
  <!--    <div class="col-lg-6">-->
  <!--      <a class="box_news" href="javascript:void(0)">-->
  <!--        <figure>-->
  <!--          <img src="{{asset('images/img/blog-thumb-placeholder.jpg')}}" data-src="{{asset('images/img/blog-thumb-1.jpg')}}" alt="" width="400" height="266"-->
  <!--            class="lazy">-->
  <!--          <figcaption><strong>28</strong>Dec</figcaption>-->
  <!--        </figure>-->
  <!--        <ul>-->
  <!--          <li>by Mark Twain</li>-->
  <!--          <li>20.11.2017</li>-->
  <!--        </ul>-->
  <!--        <h4>Pri oportere scribentur eu</h4>-->
  <!--        <p>Cu eum alia elit, usu in eius appareat, deleniti sapientem honestatis eos ex. In ius esse ullum-->
  <!--          vidisse....</p>-->
  <!--      </a>-->
  <!--    </div>-->
      
  <!--    <div class="col-lg-6">-->
  <!--      <a class="box_news" href="javascript:void(0)">-->
  <!--        <figure>-->
  <!--          <img src="{{asset('images/img/blog-thumb-placeholder.jpg')}}" data-src="{{asset('images/img/blog-thumb-2.jpg')}}" alt="" width="400" height="266"-->
  <!--            class="lazy">-->
  <!--          <figcaption><strong>28</strong>Dec</figcaption>-->
  <!--        </figure>-->
  <!--        <ul>-->
  <!--          <li>By Jhon Doe</li>-->
  <!--          <li>20.11.2017</li>-->
  <!--        </ul>-->
  <!--        <h4>Duo eius postea suscipit ad</h4>-->
  <!--        <p>Cu eum alia elit, usu in eius appareat, deleniti sapientem honestatis eos ex. In ius esse ullum-->
  <!--          vidisse....</p>-->
  <!--      </a>-->
  <!--    </div>-->
      
  <!--    <div class="col-lg-6">-->
  <!--      <a class="box_news" href="javascript:void(0)">-->
  <!--        <figure>-->
  <!--          <img src="{{asset('images/img/blog-thumb-placeholder.jpg')}}" data-src="{{asset('images/img/blog-thumb-3.jpg')}}" alt="" width="400" height="266"-->
  <!--            class="lazy">-->
  <!--          <figcaption><strong>28</strong>Dec</figcaption>-->
  <!--        </figure>-->
  <!--        <ul>-->
  <!--          <li>By Luca Robinson</li>-->
  <!--          <li>20.11.2017</li>-->
  <!--        </ul>-->
  <!--        <h4>Elitr mandamus cu has</h4>-->
  <!--        <p>Cu eum alia elit, usu in eius appareat, deleniti sapientem honestatis eos ex. In ius esse ullum-->
  <!--          vidisse....</p>-->
  <!--      </a>-->
  <!--    </div>-->
      
  <!--    <div class="col-lg-6">-->
  <!--      <a class="box_news" href="javascript:void(0)">-->
  <!--        <figure>-->
  <!--          <img src="{{asset('images/img/blog-thumb-placeholder.jpg')}}" data-src="{{asset('images/img/blog-thumb-4.jpg')}}" alt="" width="400" height="266"-->
  <!--            class="lazy">-->
  <!--          <figcaption><strong>28</strong>Dec</figcaption>-->
  <!--        </figure>-->
  <!--        <ul>-->
  <!--          <li>By Paula Rodrigez</li>-->
  <!--          <li>20.11.2017</li>-->
  <!--        </ul>-->
  <!--        <h4>Id est adhuc ignota delenit</h4>-->
  <!--        <p>Cu eum alia elit, usu in eius appareat, deleniti sapientem honestatis eos ex. In ius esse ullum-->
  <!--          vidisse....</p>-->
  <!--      </a>-->
  <!--    </div>-->
      
  <!--  </div>    -->
  <!--</div>-->



@include('web.common.scripts.addToCompare')
@include('web.common.scripts.Like')
@endsection