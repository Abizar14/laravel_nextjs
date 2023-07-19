<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="{{ asset('adminlte/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('adminlte/css/style2.css') }}">
	<title>AdminSite</title>
</head>
<body>
	
	<!-- SIDEBAR -->
	@include('layouts.sidebar')

	<!-- NAVBAR -->
	<section id="content">
    <nav>
      <i class='bx bx-menu toggle-sidebar' ></i>
      <form action="#">
        <div class="form-group">
          <input type="text" placeholder="Search...">
          <i class='bx bx-search icon' ></i>
        </div>
      </form>
      <a href="#" class="nav-link">
        <i class='bx bxs-bell icon' ></i>
        <span class="badge">5</span>
      </a>
      <a href="#" class="nav-link">
        <i class='bx bxs-message-square-dots icon' ></i>
        <span class="badge">8</span>
      </a>
      <span class="divider"></span>
      <div class="profile">
        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?ixid=MnwxMjA3fDB8MHxzZWFyY2h8NHx8cGVvcGxlfGVufDB8fDB8fA%3D%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=60" alt="">
        <ul class="profile-link">
          <li><a href="#"><i class='bx bxs-user-circle icon' ></i> Profile</a></li>
          <li><a href="#"><i class='bx bxs-cog' ></i> Settings</a></li>
          <li><a href="#"><i class='bx bxs-log-out-circle' ></i> Logout</a></li>
        </ul>
      </div>
    </nav>
    <!-- NAVBAR -->
    @yield('content')
      <!-- MAIN -->
  
  </section>
	<!-- NAVBAR -->

	<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
	<script src="{{ asset('adminlte/js/script.js') }}"></script>
</body>
</html>