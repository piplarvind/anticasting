@extends('layouts.account')
<div class="breadcrumbs">
    <div class="page-header d-flex align-items-center" style="background-image: url('{{ asset('assets/website/images/page-banner.png') }}');">
      <div class="container position-relative">
        <div class="row d-flex justify-content-center">
          <div class="col-lg-6 text-center">
            <h2>Dashboard</h2>
            {{-- <p>Explore your profile</p> --}}
          </div>
        </div>
      </div>
    </div>
    <nav>
      <div class="container">
        <ol>
          <li><a href="{{ url('/') }}">Home</a></li>
          <li>Dashboard</li>
        </ol>
      </div>
    </nav>
  </div>
<h3>Dashboard</h3>