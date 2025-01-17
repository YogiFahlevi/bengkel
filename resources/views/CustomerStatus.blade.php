<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Customer Status</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('assets/vendors/feather/feather.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/ti-icons/css/themify-icons.css')}}">
  <link rel="stylesheet" href="{{asset('assets/vendors/css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css')}}">
  <link rel="stylesheet" type="text/css" href="{{asset('assets/js/select.dataTables.min.css')}}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('assets/css/vertical-layout-light/style.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('assets/images/favicon.png')}}" />
</head>

<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <a class="navbar-brand brand-logo mr-5" href="index.html">
          <img src="{{asset('assets/images/logoxclus.png')}}" class="mr-2" alt="logo" width="100%" />
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
        <ul class="navbar-nav mr-lg-2"></ul>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" href="/portal" data-toggle="dropdown" id="profileDropdown">
              <img src="{{asset('assets/images/logomini.png')}}" alt="profile" />
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
              <span class="menu-title">Riwayat Pembelian</span>
            </a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="/">
              <i class="icon-grid menu-icon"></i>
              <span class="menu-title">Home</span>
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

                  @if(Auth::check())
                  <h4 class="card-title">Riwayat Pembelian: {{ Auth::user()->email }}</h4>
                  @endif


                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Nama</th>
                          <th>Alamat</th>
                          <th>Tipe Mobil</th>
                          <th>Tipe Motor</th>
                          <th>No HP</th>
                          <th>Paket Salon Mobil</th>
                          <th>Paket Salon Motor</th>
                          <th>Katalog</th>
                          <th>Tanggal</th>
                          <th>Gambar</th>
                          <th>Bukti TF</th>
                          <th>Status</th>
                          @if(auth()->user()->role == 'cashier')
                          <th>Aksi</th>
                          <th>Opsi</th>
                          @endif

                          <th>Antrian</th>
                          <th>Opsi</th>
                          <th>Invoice</th>
                          <!-- <th>Upload</th> -->
                        </tr>
                      </thead>
                      <tbody>
  @foreach($bukuTamus as $bukuTamu)
  <tr>
    <td>{{ $bukuTamu->nama }}</td>
    <td>{{ $bukuTamu->alamat }}</td>
    <td>{{ $bukuTamu->tipe_mobil }}</td>
    <td>{{ $bukuTamu->tipe_motor }}</td>
    <td>{{ $bukuTamu->no_hp }}</td>
    <td>{{ $bukuTamu->paket_salon_mobil }}</td>
    <td>{{ $bukuTamu->paket_salon_motor }}</td>
    <td>{{ $bukuTamu->katalog }}</td>
    <td>{{ $bukuTamu->tanggal }}</td>
    <td>
      @if($bukuTamu->gambar)
      <a href="{{ Storage::url($bukuTamu->gambar) }}" target="_blank">Lihat Gambar</a>
      @else
      Belum diunggah
      @endif
    </td>
    <td>
      @if($bukuTamu->Bukti_Tf)
      <a href="{{ asset('storage/images/bukti_pembayaran/'.$bukuTamu->Bukti_Tf) }}" target="_blank">Lihat Bukti TF</a>
      @else
      <a href="/pembayaran" class="text-warning font-weight-bold">Belum dibayar</a>
      @endif
    </td>

    <!-- Modifikasi di sini untuk menampilkan "menunggu konfirmasi" -->
    <td>
      {{ $bukuTamu->status === 'Lunas' ? $bukuTamu->status : 'Menunggu Konfirmasi' }}
    </td>

    @if(auth()->user()->role == 'cashier')
    <td><a href="/approved/{{ $bukuTamu->id_user }}" class="btn btn-success mr-2">Lunas</a></td>
    <td><a href="/delete/{{ $bukuTamu->id_user }}" class="btn btn-danger mr-2">Delete</a></td>
    @endif

    <!-- Modifikasi di sini untuk menampilkan "menunggu konfirmasi" -->
    <td>
      {{ $bukuTamu->nomor_antrian ?? 'Menunggu Konfirmasi' }}
    </td>

    <td>
      <form action="{{ route('bukuTamu.destroy', $bukuTamu->id_user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this item?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
      </form>
    </td>
    <td>
      @if($bukuTamu->status === 'Lunas')
      <a href="{{ route('generate.invoice', $bukuTamu->id) }}" class="btn btn-primary">Download Invoice</a>
      @endif
    </td>
  </tr>
  @endforeach
</tbody>

                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="main-panel">
              <div class="content-wrapper">
                <div class="row">
                  <div class="col-lg-9 grid-margin stretch-card">
                    <div class="card">
                      <div class="card-body">
                        <h2 class="card-title">PERINGATAN !!!</h2>
                        <p style="color: black;">Apakah anda ingin melanjutkan Transaksi? Jika Iya Klik Button "Pembayaran"</p>
                        <a href="pembayaran" class="btn btn-primary">Pembayaran</a>
                        <br><br>
                        <p style="color: black;">Jika Tidak Silahkan klik button "Delete" scroll kesamping di Riwayat Pembelian </p>
                        <p style="color: black;">JIKA SUDAH LUNAS ABAIKAN PESAN INI ! </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
          <!-- main-panel ends -->
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
      <script src="{{asset('assets/vendors/chart.js/Chart.min.js')}}"></script>
      <script src="{{asset('assets/vendors/datatables.net/jquery.dataTables.js')}}"></script>
      <script src="{{asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js')}}"></script>
      <script src="{{asset('assets/js/dataTables.select.min.js')}}"></script>
      <!-- End plugin js for this page -->
      <!-- inject:js -->
      <script src="{{asset('assets/js/off-canvas.js')}}"></script>
      <script src="{{asset('assets/js/hoverable-collapse.js')}}"></script>
      <script src="{{asset('assets/js/template.js')}}"></script>
      <script src="{{asset('assets/js/settings.js')}}"></script>
      <script src="{{asset('assets/js/todolist.js')}}"></script>
      <!-- endinject -->
      <!-- Custom js for this page-->
      <script src="{{asset('assets/js/dashboard.js')}}"></script>
      <script src="{{asset('assets/js/Chart.roundedBarCharts.js')}}"></script>
      <!-- End custom js for this page-->

      <script>
        function uploadFile(buttonElement) {
          const dataId = buttonElement.getAttribute('data-id');
          const fileInput = document.getElementById(`file-upload-${dataId}`);
          const file = fileInput.files[0];

          if (!file) {
            alert('Please select a file first.');
            return;
          }

          const formData = new FormData();
          formData.append('file', file);

          fetch(`/upload/${dataId}`, {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Get CSRF token from meta tag
              },
              body: formData,
            })
            .then(response => response.json())
            .then(data => {
              console.log('Success:', data);
              alert('File uploaded successfully!');
              // Optionally refresh the table or update the view here
            })
            .catch((error) => {
              console.error('Error:', error);
              alert('Failed to upload file.');
            });
        }
      </script>
</body>

</html>