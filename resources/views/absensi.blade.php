@extends('layouts.app')

@section('content')
<main>
  <h1 class="title">Dashboard</h1>
  <ul class="breadcrumbs">
    <li><a href="#">Home</a></li>
    <li class="divider">/</li>
    <li><a href="#" class="active">Dashboard</a></li>
  </ul>
  <div class="info-data">
    <div class="card">
      <div class="head">
        <div>
          <h2>-</h2>
          <p>Kehadiran</p>
        </div>
        <i class='bx bx-trending-up icon' ></i>
      </div>
      <span class="progress" data-value="40%"></span>
      <span class="label">40%</span>
    </div>
    <div class="card">
      <div class="head">
        <div>
          <h2>-</h2>
          <p>Izin</p>
        </div>
        <i class='bx bx-trending-down icon down' ></i>
      </div>
      <span class="progress" data-value="60%"></span>
      <span class="label">60%</span>
    </div>
    <div class="card">
      <div class="head">
        <div>
          <h2>-</h2>
          <p>Cuti</p>
        </div>
        <i class='bx bx-trending-up icon' ></i>
      </div>
      <span class="progress" data-value="30%"></span>
      <span class="label">30%</span>
    </div>
    <div class="card">
      <div class="head">
        <div>
          <h2>-</h2>
          <p>Lembur</p>
        </div>
        <i class='bx bx-trending-up icon' ></i>
      </div>
      <span class="progress" data-value="80%"></span>
      <span class="label">80%</span>
    </div>
  </div>

  <div class="table-data">
    <div class="order">
      <div class="head">
        <h3>Recent Orders</h3>
        <i class='bx bx-search' ></i>
        <i class='bx bx-filter' ></i>
      </div>
      <table>
        <thead>
          <tr>
            <th>User</th>
            <th>Kehadiran</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>
              <img src="img/people.png">
              <p>John Doe</p>
            </td>
            <td>01-10-2021</td>
            <td><span class="status completed">Completed</span></td>
          </tr>
          <tr>
            <td>
              <img src="img/people.png">
              <p>John Doe</p>
            </td>
            <td>01-10-2021</td>
            <td><span class="status pending">Pending</span></td>
          </tr>
          <tr>
            <td>
              <img src="img/people.png">
              <p>John Doe</p>
            </td>
            <td>01-10-2021</td>
            <td><span class="status process">Process</span></td>
          </tr>
          <tr>
            <td>
              <img src="img/people.png">
              <p>John Doe</p>
            </td>
            <td>01-10-2021</td>
            <td><span class="status pending">Pending</span></td>
          </tr>
          <tr>
            <td>
              <img src="img/people.png">
              <p>John Doe</p>
            </td>
            <td>01-10-2021</td>
            <td><span class="status completed">Completed</span></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</main>
  
@endsection