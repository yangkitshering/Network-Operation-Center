@extends('layouts.app2')

@section('content')

<!-- Section -->
<section id="hero-area">
  <div class="container">
    <div class="row">
      <div class="col-md-12 text-center">
        <div class="block wow fadeInUp" data-wow-delay=".3s">

          <!-- Slider -->
          <section class="cd-intro">
            <h1 class="wow fadeInUp animated cd-headline slide" data-wow-delay=".4s">
              <span>Network Operation Center (NOC)</span><br>
              <span class="cd-words-wrapper">
                <b class="is-visible">Register Your Request</b>
                <b>Wait for Approval</b>
                <b>Receive Confirmation</b>
              </span>
            </h1>
          </section> <!-- cd-intro -->
          <!-- /.slider -->
          <br>
          <h2 class="wow fadeInUp animated" data-wow-delay=".6s">
            Submit your request approval for visiting NOC server access. Your admin/approval will receive your request.
            After verification you will be notified back on your request.
          </h2>
          <a class="btn-lines dark light wow fadeInUp animated btn btn-default btn-green hvr-bounce-to-right"
            data-wow-delay=".9s" href="https://www.bt.bt/" target="_blank">Learn More</a>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/#main-slider-->

<!--
==================================================
About Section Start
================================================== -->
<section id="about">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-sm-6">
        <div class="block wow fadeInLeft" data-wow-delay=".3s" data-wow-duration="500ms">
          <h2>
            ABOUT US
          </h2>
          <p>
            Bhutan Telecom Limited (BTL) is the leading provider of telecommunications and Internet services
            in the Kingdom of Bhutan. Besides fixed line telephony, it provides GSM Mobile services
            under its flagship brand B-Mobile, and Internet Services under the brand name of DrukNet.
            It is the leading provider of both mobile telephony and Internet services in the country,
            and the only fixed line telephony services provider in the country.
          </p>
          <p>
            NOC
          </p>
        </div>

      </div>
      <div class="col-md-6 col-sm-6">
        <div class="block wow fadeInRight" data-wow-delay=".3s" data-wow-duration="500ms">
          <img src="images/ABOUT-US.png" alt="">
        </div>
      </div>
    </div>
  </div>
</section> <!-- /#about -->

<!--
    ==================================================
    Portfolio Section Start
    ==================================================
  -->

{{-- <section id="feature">
  <div class="container">
    <div class="section-heading">
      <h1 class="title wow fadeInDown" data-wow-delay=".3s">Features</h1>
      <p class="wow fadeInDown" data-wow-delay=".5s">
        Why Blockchain for Digital Certificates?
      </p>
    </div>
    <div class="row">
      <div class="col-sm-6 col-lg-4">
        <div class="media wow fadeInUp animated" data-wow-duration="500ms" data-wow-delay="300ms">
          <div class="media-left">
            <div class="icon">
              <i class="ion-ios-flask-outline"></i>
            </div>
          </div>
          <div class="media-body">
            <h4 class="media-heading">Simple</h4>
            <p>Simple and easy to register and view the certificates.</p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="media wow fadeInDown animated" data-wow-duration="500ms" data-wow-delay="600ms">
          <div class="media-left">
            <div class="icon">
              <i class="ion-ios-lightbulb-outline"></i>
            </div>
          </div>
          <div class="media-body">
            <h4 class="media-heading">User Friendly</h4>
            <p>User friendly interface for seamless performance.</p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="media wow fadeInDown animated" data-wow-duration="500ms" data-wow-delay="900ms">
          <div class="media-left">
            <div class="icon">
              <i class="ion-ios-lightbulb-outline"></i>
            </div>
          </div>
          <div class="media-body">
            <h4 class="media-heading">Secure</h4>
            <p>Data registered to blockchain is secure and immutable.</p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="media wow fadeInDown animated" data-wow-duration="500ms" data-wow-delay="1200ms">
          <div class="media-left">
            <div class="icon">
              <i class="ion-ios-americanfootball-outline"></i>
            </div>
          </div>
          <div class="media-body">
            <h4 class="media-heading">Ethereum Network</h4>
            <p>Uses the most popular Decentralized Application Network</p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="media wow fadeInDown animated" data-wow-duration="500ms" data-wow-delay="1500ms">
          <div class="media-left">
            <div class="icon">
              <i class="ion-ios-keypad-outline"></i>
            </div>
          </div>
          <div class="media-body">
            <h4 class="media-heading">Metamask Wallet Support</h4>
            <p>Supports metamask wallet for transactions</p>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="media wow fadeInDown animated" data-wow-duration="500ms" data-wow-delay="1800ms">
          <div class="media-left">
            <div class="icon">
              <i class="ion-ios-barcode-outline"></i>
            </div>
          </div>
          <div class="media-body">
            <h4 class="media-heading">Versatile</h4>
            <p>Features can be added in future.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section> <!-- /#feature --> --}}

<!-- FootNote -->
<section id="call-to-action">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="block">
          <h2 class="title wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">Network Operation Center</h1>
            <p class="wow fadeInDown" data-wow-delay=".5s" data-wow-duration="500ms">
              Bhutan Telecom Limited
            </p>
            <a href="{{ route('feedback') }}" class="btn btn-default btn-contact wow fadeInDown" data-wow-delay=".7s"
              data-wow-duration="500ms">Leave us a Feedback</a>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection