<script>
function showResult(str) {
  if (str.length==0) {
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";
    return;
  }
  var xmlhttp=new XMLHttpRequest();
  xmlhttp.onreadystatechange=function() {
    if (this.readyState==4 && this.status==200) {
      document.getElementById("livesearch").innerHTML=this.responseText;
      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
    }
  }
  xmlhttp.open("GET","category.php?q="+str,true);
  xmlhttp.send();
}
</script>

<nav class="navbar navbar-expand-lg navbar-light sticky-top bg-light">
    <a class="navbar-brand" href="index.php">
        <img src="artrate.png" width="30" height="30" class="d-inline-block align-top" alt="">
        Art Rate
    </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <form class="form-inline" action="index.php" method='get' style="margin-left:auto; width:70%;">
      <input class="form-control mr-sm-2" style="width:65%" type="text" placeholder="Search" onkeyup="showResult(this.value)" name="categ" aria-label="Search">
      <div id="livesearch"></div>
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
    <ul class="navbar-nav mr-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home 
          <!-- <span class="sr-only">(current)</span> -->
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="upload.php">Upload</a>
      </li>
    </ul>
  </div>
</nav>