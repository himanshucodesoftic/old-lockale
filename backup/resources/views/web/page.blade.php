@extends('web.layout')
@section('content')

<section class="aboutus-content aboutus-content-one" style="margin-top: 0; padding: 40px 0;">
  <div class="container">
    <div class="heading">
      <h2>
      <?=$result['pages'][0]->name?>
      </h2>
      <hr style="margin-bottom: 10;">
    </div>
  <?=stripslashes($result['pages'][0]->description)?>     
  </div>

</section>

@endsection
