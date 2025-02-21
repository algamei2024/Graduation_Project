<html>
<head>
  <title>choose color</title>
</head>
<body>
  <h1 id='colorText'>Choose Color</h1>

  <form action='{{route("store.color")}}' method='post'>
  @csrf
  <input type="color" id="idColor" name='color' />

  <input type='submit' value='حفظ' />

  </form>




  <!-- <script>
    var color = document.getElementById('idColor');
    var colorText = document.getElementById('colorText');

    color.addEventListener('input',function(){
        // colorText.style.color=color.value;
        colorText.style.color='#000';
        // colorText.innerH1TML=color.value;
        console.log(color.value);
    });
</script> -->

</body>
</html>
