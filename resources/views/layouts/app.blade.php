<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="admin, dashboard">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Dompet : Payment Admin Template">
	<meta property="og:title" content="Dompet : Payment Admin Template">
	<meta property="og:description" content="Dompet : Payment Admin Template">
	<meta property="og:image" content="https://dompet.dexignlab.com/xhtml/social-image.png">
	<meta name="format-detection" content="telephone=no">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	<!-- PAGE TITLE HERE -->
	<title>Visitors Menagement System</title>
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="images/FormLogin.jpeg">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
	
	<link href="vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link rel="stylesheet" href="vendor/nouislider/nouislider.min.css">
	<!-- Style css -->
    <link href="css/style.css" rel="stylesheet">
	<style>
        .carddate {
            display: flex;
            align-items: center; /* Center align items vertically */
            justify-content: center; /* Center align items horizontally */
            width: 150px; /* Set a fixed width */
            height: 50px;
            border: 1px solid #ccc;
            text-align: center; /* Center text */
            padding: 5px; /* Add some padding for better spacing */
            margin-right: 0; /* Remove right margin */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add shadow */
            background-color: white; /* Ensure background is white */
        }

        .carddate i {
            font-size: 16px; /* Reduce the icon size */
            margin-right: 5px; /* Add some space between icon and text */
        }

        .clock, .date {
            font-size: 14px;
            font-weight: bold;
        }

        .dashboard_bar {
            display: flex;
        }
    </style>
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        {{-- <div class="waviy">
		   <span style="--i:1">L</span>
		   <span style="--i:2">o</span>
		   <span style="--i:3">a</span>
		   <span style="--i:4">d</span>
		   <span style="--i:5">i</span>
		   <span style="--i:6">n</span>
		   <span style="--i:7">g</span>
		   <span style="--i:8">.</span>
		   <span style="--i:9">.</span>
		   <span style="--i:10">.</span>
		</div> --}}
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
		<div class="nav-header">
            <a href="#" class="brand-logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="175" height="175" viewBox="0 0 110 120">
                    <image href="images/LogoSinarmas.jpg" x="0" y="0" width="110" height="120" />
                </svg>
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Chat box start
        ***********************************-->
		<div class="chatbox">
			<div class="chatbox-close"></div>
			<div class="custom-tab-1">
				<div class="tab-content">
					
				</div>
			</div>
		</div>
		<!--**********************************
            Chat box End
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
		<div class="header">
			<div class="header-content">
				<nav class="navbar navbar-expand">
					<div class="collapse navbar-collapse justify-content-between">
						<div class="header-left">
							<div class="dashboard_bar">
								<div class="carddate">
									<i class="fa-regular fa-calendar-days" style="color: #0D568B;"></i>
									<div class="date" id="date" style="color: #0D568B;"></div>
								</div>
								<div class="carddate">
									<i class="fa-solid fa-clock" style="color: #0D568B;"></i>
									<div class="clock" id="clock" style="color: #0D568B;"></div>
								</div> 
							</div>
						</div>
						<ul class="navbar-nav header-right">
							<li class="nav-item dropdown header-profile" style="align-content:center;">
								<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
									<img src="{{ asset(Auth::user()->foto_profil) }}" width="40" height="40" class="rounded-circle align-middle" alt="Profile Picture">
									<div class="d-inline-block align-middle" style="color: black">
										{{ Auth::user()->username }}
										<div style="font-size: 12px; color: grey;">User Account</div>
									</div>
								</a>
								<div class="dropdown-menu dropdown-menu-end" style="width:350px">
									<div class="text-center py-3 border-bottom">
										<img src="{{ asset(Auth::user()->foto_profil) }}" width="80" height="80" class="rounded-circle" alt="Profile Picture">
										<h5 class="font-w600 mt-3">{{ Auth::user()->username }}</h5>
									</div>
									<div class="row">
										<div class="col text-end">
											<a href="{{ route('profile') }}" class="dropdown-item ai-icon">
												<svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#007bff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
													<circle cx="12" cy="7" r="4"></circle>
												</svg>												
												<span class="ms-2">Profile</span>
											</a>
										</div>
										<div class="col">
											<a href="{{ route('logout') }}" class="dropdown-item ai-icon">
												<svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
													<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
													<polyline points="16 17 21 12 16 7"></polyline>
													<line x1="21" y1="12" x2="9" y2="12"></line>
												</svg>
												<span class="ms-2">Logout</span>
											</a>
										</div>
									</div>
								</div>
							</li>                                                    
						</ul>     
					</div>
				</nav>
			</div>
		</div>
		
        <!--**********************************
            Header end ti-comment-alt        
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <div class="dlabnav">
			<div class="dlabnav-scroll">
				<ul class="metismenu" id="menu">
					<li>
						<a href="beranda" class="ai-icon" aria-expanded="false">
							<i class="flaticon-025-dashboard"></i>
							<span class="nav-text">Dashboard</span>
						</a>
					</li>
					<li>
						<a href="buat_undangan" class="ai-icon" aria-expanded="false">
							<i class="flaticon-022-copy"></i>
							<span class="nav-text">Buat Kunjungan</span>
						</a>
					</li>
					<li>
						<a href="{{ route('index_riwayat_pengunjung.show') }}" class="ai-icon" aria-expanded="false">
							<i class="fa-solid fa-clock-rotate-left"></i>
							<span class="nav-text">Riwayat</span>
						</a>
					</li>
					<li>
						<a href="informasi_kunjungan" class="ai-icon" aria-expanded="false">
							<i class="fa-solid fa-circle-info"></i>
							<span class="nav-text">Informasi Kunjungan</span>
						</a>
					</li>
				</ul>
				<div class="copyright">
					<p><strong>Visitors Management System</strong> © 2024 All Rights Reserved</p>
					<!-- <p class="fs-12">Developed by [Your Company]</p> -->
				</div>
			</div>
		</div>
		
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				@yield('content')
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
		
		
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p><strong>Visitors Management System</strong> © 2024 All Rights Reserved</p>
                <p class="fs-12">Developed by [Your Company]</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->
			


	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/dlabnav-init.js"></script>
	<script src="js/demo.js"></script>
    <script src="js/styleSwitcher.js"></script>

	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<!-- Setelah tag form pada bagian body -->
	@if(Session::has('success'))
	<script>
		Swal.fire({
			icon: "success",
			title: "Login Berhasil!",
			showConfirmButton: false,
			confirmButtonColor: "#0265F3"
			timer: 1500
		});
	</script>
	@endif
	@if(session('login_berhasil'))
    <script>
        Swal.fire({
            icon: "success",
            title: "Login Berhasil!",
			confirmButtonColor: "#0265F3"
        });
    </script>
@endif

<script>
    // Update waktu dan tanggal secara live
    function updateClock() {
        var now = new Date();
        var hours = now.getHours();
        var minutes = now.getMinutes();
        var seconds = now.getSeconds();
        var ampm = hours >= 12 ? 'PM' : 'AM';

        // Convert to 12-hour format
        hours = hours % 12;
        hours = hours ? hours : 12; // The hour '0' should be '12'

        // Format waktu dengan menambahkan angka 0 di depan jika hanya satu digit
        hours = hours < 10 ? '0' + hours : hours;
        minutes = minutes < 10 ? '0' + minutes : minutes;
        seconds = seconds < 10 ? '0' + seconds : seconds;

        // Tampilkan waktu pada elemen dengan id 'clock'
        document.getElementById('clock').innerText = hours + ':' + minutes + ':' + seconds + ' ' + ampm;

        // Tampilkan tanggal pada elemen dengan id 'date'
        var days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var day = days[now.getDay()];
        var month = months[now.getMonth()];
        var date = now.getDate();
        var year = now.getFullYear();
        document.getElementById('date').innerText = date + ' ' + month + ' ' + year;

        // Panggil kembali fungsi setiap detik
        setTimeout(updateClock, 1000);
    }

    // Panggil fungsi untuk pertama kali saat halaman dimuat
    updateClock();
    </script>
	<script>
		var response = true;
	
	function request(){
		if(response == true){
			response = false;
			var req = $.ajax({
				type: "GET",
				url: "/check-and-update-status",
				dataType: 'json' // Ensure the response is JSON
			});
	
			req.done(function(data){
				console.log("Request successful!", data);
				$('#undanganMasukCount').text(data.undangan_masuk);
				$('#undanganDatangCount').text(data.undangan_akan_datang);
				$('#undanganKadaluarsaCount').text(data.undangan_kadaluarsa);
				response = true;
			});
	
			req.fail(function(jqXHR, textStatus, errorThrown){
				console.error("Request failed: ", textStatus, errorThrown);
				response = true;
			});
		}
	
		setTimeout(request, 1000); // Polling interval set to 1 second
	}
	
	$(document).ready(function() {
		request();
	});
	
	</script>

	<script>
		function updateUndanganStatus() {
    fetch('/update-undangan-status', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({})
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            console.log(data.message);
        } else {
            console.log('Tidak ada pembaruan status.');
        }
    })
    .catch(error => {
        console.error('Terjadi kesalahan:', error);
    });
}

// Panggil fungsi updateUndanganStatus setiap 10 detik (10000 milidetik)
setInterval(updateUndanganStatus, 10000);

	</script>
	
</body>
</html>