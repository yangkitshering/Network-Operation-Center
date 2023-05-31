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
              <span>Network Operation Center, BT</span><br>
              <span class="cd-words-wrapper">
                <b class="is-visible">Request</b>
                <b>Approve</b>
                <b>Enter</b>
              </span>
            </h1>
          </section> <!-- cd-intro -->
          <!-- /.slider -->
          <h2 class="wow fadeInUp animated" data-wow-delay=".6s">
            NOC, Network Operation Center System
          </h2>
          <a class="btn-lines dark light wow fadeInUp animated btn btn-default btn-green hvr-bounce-to-right"
            data-wow-delay=".9s" href="https://themefisher.com/" target="_blank">Learn More</a>
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
            ABOUT Blockchain
          </h2>
          <p>
            A blockchain is a type of distributed ledger technology (DLT) that consists of growing list of records,
            called blocks, that are securely linked together using cryptography. Each block contains a
            cryptographic hash of the previous block, a timestamp, and transaction data.
          </p>
          <p>
            Blockchain transactions are irreversible in that, once they are
            recorded, the data in any given block cannot be altered retroactively without altering all subsequent
            blocks.
          </p>
          <p>
            Source: <b>Wikipedia</b>
          </p>
        </div>

      </div>
      <div class="col-md-6 col-sm-6">
        <div class="block wow fadeInRight" data-wow-delay=".3s" data-wow-duration="500ms">
          <img src="images/blockchain.png" alt="">
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

<section id="feature">
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
</section> <!-- /#feature -->

<!-- FootNote -->
<section id="call-to-action">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="block">
          <h2 class="title wow fadeInDown" data-wow-delay=".3s" data-wow-duration="500ms">First Blockchain Application
            in Bhutan</h1>
            <p class="wow fadeInDown" data-wow-delay=".5s" data-wow-duration="500ms">
              The very first decentralized application in Bhutan.
            </p>
            <a href="contact.html" class="btn btn-default btn-contact wow fadeInDown" data-wow-delay=".7s"
              data-wow-duration="500ms">Leave a Feedback</a>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection