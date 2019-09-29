<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Converter</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>

<div id="wrapper">
    <div class="container d-flex align-items-center justify-content-center mt-5">
        <form action="{{ route('converter') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <!-- <div class="form-group d-flex flex-row">
                <label for="" class="mr-3" style="min-width: 30px">Title: </label>
                <input type="text" name="converter[title]" class="form-control"/>
            </div> -->
            <div class="form-group d-flex flex-row align-items-center">
                <label for="" class="mr-3" style="min-width: 50px">File: </label>
                <input type="file" name="converter[file]" class="form-control"/>
            </div>
            <div class="form-group d-flex flex-row align-items-center">
                <label for="" class="mr-3" style="min-width: 50px">Gender: </label>
                <select name="converter[gender]" id="" class="form-control">
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                    <option value="3" selected>Neutral</option>
                </select>
            </div>
            <div class="form-group d-flex flex-row align-items-center">
                <label for="" class="mr-3" style="min-width: 50px">Speed: </label>
                <select name="converter[speed]" id="" class="form-control">
                    @for($i = 0.5; $i < 2.1; $i = $i + 0.1)
                    <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="form-group d-flex flex-row align-items-center">
                <label for="" class="mr-3" style="min-width: 50px">Effect: </label>
                <select name="converter[effect]" id="" class="form-control">
                    <option value="wearable-class-device">wearable-class-device</option>
                    <option value="handset-class-device">handset-class-device</option>
                    <option value="headphone-class-device" selected>headphone-class-device</option>
                    <option value="small-bluetooth-speaker-class-device">small-bluetooth-speaker-class-device</option>
                    <option value="medium-bluetooth-speaker-class-device">medium-bluetooth-speaker-class-device</option>
                    <option value="large-home-entertainment-class-device">large-home-entertainment-class-device</option>
                    <option value="large-automotive-class-device">large-automotive-class-device</option>
                    <option value="telephony-class-application">telephony-class-application</option>
                </select>
            </div>
            <div class="form-group text-center mt-4">
                <button type="submit" class="btn btn-primary">Converter</button>
            </div>
        </form>
    </div>
</div>
<div class="footer">
</div>
<!-- /. WRAPPER  -->
<!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
