<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Transaksi</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/js/select.dataTables.min.css') }}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('assets/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .thumbnail {
      width: 150px;
      cursor: pointer;
      transition: 0.3s;
    }

    .thumbnail:hover {
      opacity: 0.7;
    }

    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      padding-top: 60px;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgb(0, 0, 0);
      background-color: rgba(0, 0, 0, 0.9);
    }

    .modal-content {
      margin: auto;
      display: block;
      width: 80%;
      max-width: 700px;
    }

    .close {
      position: absolute;
      top: 15px;
      right: 35px;
      color: #f1f1f1;
      font-size: 40px;
      font-weight: bold;
      transition: 0.3s;
    }

    .close:hover,
    .close:focus {
      color: #bbb;
      text-decoration: none;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.html"><img src="{{ asset('assets/images/logoxclus.png') }}" class="mr-2" alt="logo" width="100%" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2"></ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="/portal" data-toggle="dropdown" id="profileDropdown">
              <img src="{{ asset('assets/images/logomini.png') }}" alt="profile" />
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
              <a class="dropdown-item" href="/portal">
                <i class="ti-power-off text-primary"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item active">
            <a class="nav-link" href="index.html">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Transaksi</span>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="kasir">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Kembali</span>
            </a>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Data Transaksi</h4>

                  <!-- Form untuk filter berdasarkan tanggal -->
                  <form action="{{ route('filter.transactions') }}" method="GET" class="mb-4">
                    <div class="form-row">
                      <div class="col-md-4">

                        <label for="start_date" class="text-black">Tanggal Mulai:</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                      </div>
                      <div class="col-md-4">
                        <label for="end_date" class="text-black">Tanggal Akhir:</label>
                        <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                      </div>
                      <div class="col-md-4 align-self-end">
                        <button type="submit" class="btn btn-primary mt-2">Filter</button>
                      </div>
                    </div>
                  </form>

                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <!-- Tabel transaksi Anda -->
                      <thead>
                        <tr>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Tipe Mobil</th>
                          <th>No HP</th>
                          <th>Paket Salon Mobil</th>
                          <th>Paket Salon Motor</th>
                          <th>Katalog</th>
                          <th>Tanggal</th>
                          <th>Selfie</th>
                          <th>Bukti Pembayaran</th>
                          <th>Status</th>
                          @if(auth()->user()->role == 'cashier')
                          <th>Aksi</th>
                          <th>Opsi</th>
                          @endif
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($bukuTamus as $bukuTamu)
                        <tr>
                          <td>{{ $bukuTamu->nama }}</td>
                          <td>{{ $bukuTamu->alamat }}</td>
                          <td>{{ $bukuTamu->tipe_mobil }}</td>
                          <td>{{ $bukuTamu->no_hp }}</td>
                          <td>{{ $bukuTamu->paket_salon_mobil }}</td>
                          <td>{{ $bukuTamu->paket_salon_motor }}</td>
                          <td>{{ $bukuTamu->katalog }}</td>
                          <td>{{ $bukuTamu->tanggal }}</td>
                          <td>
                            <a href="{{ Storage::url($bukuTamu->gambar) }}" target="_blank">Lihat Gambar</a>
                          </td>
                          <td>
                            <a href="{{ asset('storage/images/bukti_pembayaran/'.$bukuTamu->Bukti_Tf) }}" target="_blank">Lihat Bukti Pembayaran</a>
                          </td>
                          <td>{{ $bukuTamu->status }}</td>
                          @if(auth()->user()->role == 'cashier')
                          <td><a href="/approved/{{ $bukuTamu->id_user }}" class="btn btn-success mr-2">Lunas</a></td>
                          <td>
                            <form action="{{ route('bukuTamu.destroy', $bukuTamu->id_user) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan item ini?');">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-danger">Batal</button>
                            </form>
                          </td>
                          @endif
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- <footer class="footer">
        <div class="d-sm-flex justify-content-center">
          <span class="text-center text-sm-center d-block d-sm-inline-block" style="color: black;">Copyright © 2021</span>
        </div>
      </footer> -->
    </div>
  </div>
  <!-- container-scroller -->

  <!-- plugins:js -->
  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
  <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
  <script src="{{ asset('assets/js/dataTables.select.min.js') }}"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
  <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('assets/js/template.js') }}"></script>
  <script src="{{ asset('assets/js/settings.js') }}"></script>
  <script src="{{ asset('assets/js/todolist.js') }}"></script>
  <!-- endinject -->
  <!-- Custom js for this page-->
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  <script src="{{ asset('assets/js/Chart.roundedBarCharts.js') }}"></script>
  <!-- End custom js for this page-->

  <!-- Modal functionality for image viewing -->
  <div id="myModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="img01">
    <div id="caption"></div>
  </div>

  <script>
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the images and insert them inside the modal - use its "alt" text as a caption
    var images = document.getElementsByClassName('thumbnail');
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");

    for (var i = 0; i < images.length; i++) {
      images[i].onclick = function() {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
      }
    }

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }
  </script>
</body>

</html>