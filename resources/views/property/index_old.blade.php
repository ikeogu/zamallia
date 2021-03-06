@extends('layouts.front')

@section('content')
@section('title', 'Real Estate')
<section class="hero-wrap hero-wrap-2" style="background-image: url({{ asset('assets/images/bg_1.jpg') }}); background-position: center;" data-stellar-background-ratio="0.5">
      <div class="overlay"></div>
      <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-center justify-content-center">
          <div class="col-md-9 ftco-animate pb-0 text-center">
            <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="fa fa-chevron-right"></i></a></span> <span class="mr-2"><a href="{{ route('properties') }}">Properties</a> </p>
            <h1 class="mb-3 bread">Properties</h1>
          </div>
        </div>
      </div>
    </section>

      @include('layouts.shared.search-area')

    <section class="ftco-section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-md-12 heading-section text-center ftco-animate mb-5">
            <span class="subheading"> <?php echo isset($_GET['keyword'])? 'search result': 'What we offer'; ?> </span>
            <h2 class="mb-2"><?php if(isset($_GET['keyword'])):?> <?php echo $properties->count();?> <?php echo $properties->count()>1?' properties ': 'property';?>  found<?php else:?> Properties <?php endif;?></h2>
          </div>
        </div>
        <div class="row ftco-animate">
          <div class="col-md-12">
            <div class="row">
              @foreach($properties as $key => $property)
                @auth
                  @php
                  // dd($interestArr);
                    if (in_array($property->id, $interestArr)) {
                      $prop_id = array_search($property->id, $interestArr);
                      // dd($prop_id);
                    }else{
                      $prop_id='';
                    }
                  @endphp
                @endauth
                  <div class="col-md-3">
                    <div class="property-wrap ftco-animate">
                                <a href="#" class="img" style="background-image: url({{ asset('storage/properties/cover_images/'.$property->cover_photo)}});">
                                    <div class="rent-sale">
                                        <span class="{{ $property->list_type }}">{{ ucfirst($property->list_type) }}</span>
                                    </div>
                                    <p class="price"><span class="orig-price">&#x20A6; {{ number_format($property->price) }}</span></p>
                                </a>
                                <div class="text text-center">
                                    <ul class="property_list">
                                        @if($property->property_type == 'building')
                                        <li><span class="fa fa-bed"></span>{{ $property->beds }}</li>
                                        <li><span class="fa fa-bath"></span>{{ $property->baths }}</li>
                                        @else
                                        
                                        <li><span class="flaticon-floor-plan"></span>{{ $property->area }}sqft</li>
                                        @endif
                                    </ul>
                                    <h3><a href="#">{{ $property->title }}</a></h3>
                                    <span class="location">{{ $property->location }}, {{ $property->city }}</span>
                                    <a href="#" class="d-flex align-items-center justify-content-center btn-custom">
                                        <span class="fa fa-link"></span>
                                    </a>
                                     <div class="list-team d-flex align-items-center mt-2 pt-2 border-top row">
                                        <div class="col-6 text-center ">
                                          @guest
                                            <button type="button" data-toggle="modal" data-target="#like-prop-{{ $property->id }}" href="#" class="btn btn-primary curve-btn">Like <i class="fa fa-heart"></i></button>
                                          @else
                                          {{-- <button id="unlike-{{ $property->id }}" code="{{ $property->code }}" prop-id="{{ $property->id }}" type="button" class="btn btn-primary curve-btn unlike-prop d-none">unlike <i class="fa fa-thumbs-down"></i></button> --}}
                                            @if($prop_id>0)
                                              <button type="button" class="btn btn-primary curve-btn property-actions"><span class="unlike-prop text-white"  id="like-{{ $property->id }}" code="{{ $property->code }}" prop-id="{{ $prop_id }}">Unlike <i class="fa fa-thumbs-down"></i></span></button>
                                            @else
                                              <button type="button" class="btn btn-primary curve-btn property-actions"><span class="like-prop text-white"  id="like-{{ $property->id }}" code="{{ $property->code }}" prop-id="{{ $prop_id }}">Like <i class="fa fa-heart"></i></span></button>
                                            @endif
                                          @endguest
                                        </div>
                                        <div class="col-6 text-center">
                                            <a href="{{ route('property-detail', $property->slug) }}" class="btn btn-success curve-btn">View <i class="fa fa-eye"></i></a>
                                        </div>
                                        
                                    </div>
                                    {{-- <div class="list-team d-flex align-items-center mt-2 pt-2 border-top row">
                                        <div class="d-flex align-items-center">
                                            <div class="img" style="background-image: url({{ asset('assets/images/person_1.jpg')}});"></div>
                                            <h3 class="ml-2">John Dorf</h3>
                                        </div>
                                        <span class="text-right">2 weeks ago</span>
                                    </div> --}}
                                </div>
                    </div>
                  </div>
                  
                @endforeach  
                </div>
              
              <div class="text-center col-12 justify-content-center">
                  {{ $properties->links() }}
              </div>
                
            </div>
          </div>
        </div>
      </div>
              @foreach($properties as $property)
                <!-- Modal -->
                <div class="modal fade" id="like-prop-{{ $property->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">

                      <div class="modal-content">
                        <div class="modal-header">
                          {{-- <h5 class="modal-title text-center" id="exampleModalLabel">Sign in first</h5> --}}
                          <button type="button" class="close text-danger" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div class="modal-body">
                          <h5 class="text-center">Sign in first</h5>
                          <form method="POST" action="{{ route('login') }}" class="bg-light p-5 contact-form">
                            @csrf
                              <div class="form-group">
                                <input type="email" name="email" class="form-control" placeholder="your email">
                              </div>
                              <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="your password">
                              </div>
                               <button class="btn btn-primary">Login</button>
                          </form>
                        </div>
                          
                       
                        <div class="modal-footer">
                          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                         
                        </div> 
                      </div>


                    </div>
                </div>
              @endforeach
    </section>
@endsection