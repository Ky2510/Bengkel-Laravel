@if (Request()->input('search'))
<style>
  .main-footer {
    position: fixed; 
    bottom: 0; 
    width: 100%;
    background-color: #f0f0f0; 
    padding: 10px; 
  }
</style>
@endif

<footer class="main-footer">
  <strong>Copyright &copy; 2022-2023 <a href="https://adminlte.io">Bengkel Mandiri Jaya Motor</a>.</strong>
  <div class="float-right d-none d-sm-inline-block">
    <b>Version</b> 0.0.1
  </div>
</footer>