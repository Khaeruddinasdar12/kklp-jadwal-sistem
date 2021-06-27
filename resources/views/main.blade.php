
<!doctype html>
  <html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>{{config('app.name')}}</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/pricing/">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('assets/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Custom styles for this template -->
    <style type="text/css">
    html {
      font-size: 14px;
    }
    @media (min-width: 768px) {
      html {
        font-size: 16px;
      }
    }

    .container {
      max-width: 960px;
    }

    .pricing-header {
      max-width: 700px;
    }

    .card-deck .card {
      min-width: 220px;
    }

    .border-top { border-top: 1px solid #e5e5e5; }
    .border-bottom { border-bottom: 1px solid #e5e5e5; }

    .box-shadow { box-shadow: 0 .25rem .75rem rgba(0, 0, 0, .05); }
  </style>
</head>

<body>

  <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Meeting Schedule</h1>
    <p class="lead">Berikut adalah jadwal meeting yang akan terlaksana.</p>
  </div>

  <div class="container">
    <div class="card-deck mb-3 text-center">
      @foreach($data as $dt)
      <div class="card mb-4 box-shadow">
        <div class="card-header">
          <h4 class="my-0 font-weight-normal">{{$dt->nama}}</h4>
        </div>
        <div class="card-body">
          <h2 class="card-title pricing-card-title"><small class="text-muted">{{$dt->waktu}} WITA</small></h2>
          <hr>
          <h4 class="card-title pricing-card-title"><small class="text-muted">Ruangan {{$dt->ruangan}}</small></h4>
          <p>Diundang kepada :</p>
          <ul class="list-unstyled mt-3 mb-4">
            {{$dt->departemen}}
          </ul>
          <p class="text-danger">*{{$dt->deskripsi}}</p>
        </div>
      </div>
      @endforeach
    </div>

  </div>


    <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
      <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
        <script src="{{ asset('assets/popper.min.js') }}"></script>
        <script src="{{ asset('assets/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/holder.min.js') }}"></script>
        <script>
          Holder.addTheme('thumb', {
            bg: '#55595c',
            fg: '#eceeef',
            text: 'Thumbnail'
          });
        </script>
      </body>
      </html>
