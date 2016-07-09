<div id="check-wrapper">
	<div id="check-status">
		<div id="status-img">
			<i class="fa fa-user fa-5x" aria-hidden="true"></i>'
		</div>
		<input id="status-text" type="text" class="form-control" placeholder="What's on your mind?">
	</div>
	
	<div id="tagged-friends"><span>-with: </span><p id="tagged-p"></p></div>	
				
	<div id="check-with">
			<div class="input-group input-group-sm">		<!-- input-group-sm for small sizing -->
				<span class="input-group-addon" id="basic-addon1">With</span>
			  	<select id="with-search" class="form-control" aria-describedby="basic-addon1" multiple="multiple"></select>
			</div>
	</div>

	<div id="check-place">
			<div class="input-group input-group-sm">		<!-- input-group-sm for small sizing -->
				<span class="input-group-addon" id="basic-addon1">At</span>
			  	<select id="places-search" class="form-control" aria-describedby="basic-addon1"></select>
			</div>
	</div>

				
	<div id="check-publish">
		<i id="user-icon" class="fa fa-user-plus fa-2x" aria-hidden="true" onclick="showFriendsHint()"></i>		<!-- 2x for sizing -->
		<i id="place-icon" class="fa fa-map-marker fa-2x" aria-hidden="true" onclick="showPlacesHint()"></i>
		<div id="post" class="dropdown pull-right">
  			<button class="btn btn-default btn-sm dropdown-toggle" type="button" id="visibility-button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
      			Friends
  	  			<span class="caret"></span>
  			</button>
  			<ul class="dropdown-menu" aria-labelledby="visibility-button">
	    	  <li><a href="#">
	    	  		<i class="fa fa-globe" aria-hidden="true"></i>Public
	    	  	</a></li>
	    	  <li><a href="#">
	    	  		<i class="fa fa-user" aria-hidden="true"></i>Friends
	    	  </a></li>
	    	  <li><a href="#">
	    	  		<i class="fa fa-lock" aria-hidden="true"></i>Only me
	    	  </a></li>
  			</ul>
  			<button id ="post" type="button" class="btn btn-primary">Post</button>
		</div>
	</div>
</div>