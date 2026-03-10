@extends('layouts.admin')

@section('page-title','Production Test')

@section('content')
<div>
  <div class="sec-head">
    <div class="sec-title">
      <i class="fa-solid fa-film"></i>
      Production Test
    </div>
    <button class="btn-primary" onclick="testModal()">
      <i class="fa-solid fa-upload"></i>
      Test Modal
    </button>
  </div>
</div>

<!-- Simple Modal Test -->
<div id="testModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
  <div style="background: white; padding: 20px; border-radius: 8px; max-width: 400px;">
    <h3>Test Modal</h3>
    <p>Ini adalah test modal sederhana</p>
    <button onclick="closeTestModal()">Close</button>
  </div>
</div>

<script>
function testModal() {
  alert('Test modal function called!');
  document.getElementById('testModal').style.display = 'flex';
}

function closeTestModal() {
  document.getElementById('testModal').style.display = 'none';
}

console.log('Test page loaded successfully');
</script>
@endsection
