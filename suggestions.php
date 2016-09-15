<div id="suggestions">
	<div id="order-div" class="btn-group">
  		<button class="btn btn-default btn-sm dropdown-toggle" type="button" id="order-button" data-toggle="dropdown">
      		<span id="selected-order">Order by</span>
  	  		<span class="caret"></span>
  		</button>
  		<ul class="dropdown-menu" aria-labelledby="order-button">
	    	<li><a onmousedown="preOrder(this)" onclick="setOrderSelection(this)" onmouseup="afterOrder(this)" href="#">
	    		<span id="similarity-order" class="order-option">Similarity</span>
	    	</a></li>
	    	<li><a onmousedown="preOrder(this)" onclick="setOrderSelection(this)" onmouseup="afterOrder(this)" href="#">
	    		<span id="name-order" class="order-option">Name</span>
	    	</a></li>
	    	<li><a onmousedown="preOrder(this)" onclick="setOrderSelection(this)" onmouseup="afterOrder(this)" href="#">
	    		<span id="random-order" class="order-option">Shuffle!</span>
	    		</a></li>
  		</ul>
  		<div id="load-sugg-spinner"><span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span></div>
	</div>

	
	<div id="recommended">
		<div id="idhenri1234" class="recommended-user">
			<div class="user-img">
				<i class="fa fa-user fa-4x" aria-hidden="true"></i>
			</div>
			<div class="user-info">
				<span class="user-name">Henri Il Pauroso Bitri</span>
				<span class="mutual">100 mutual friends</span>
			</div>
			<div class="progress">
				<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:70%">
			    	70%
			  	</div>
			</div>
			<div class="recommended-buttons">
				<div class="btn-group" role="group" aria-label="...">
  					<button type="button" class="btn btn-success"><a href="http://www.facebook.com/idhenri1234" target="blank">Send request</a></button>
				</div>
				<div class="btn-group" role="group" aria-label="...">
  					<button onclick="viewProfile(this)" id="idhenri1234btn" type="button" class="btn btn-default">View profile</button>
				</div>
			</div>
		</div>	
		
		<div id="cotto1234" class="recommended-user">
			<div class="user-img">
				<i class="fa fa-user fa-4x" aria-hidden="true"></i>
			</div>
			<div class="user-info">
				<span class="user-name">Pancotto</span>
				<span class="mutual">100 mutual friends</span>
			</div>
			<div class="progress">
				<div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:100%">
			    	100%
			  	</div>
			</div>
			<div class="recommended-buttons">
				<div class="btn-group" role="group" aria-label="...">
  					<button type="button" class="btn btn-success"><a href="http://www.facebook.com/idhenri1234" target="blank">Send request</a></button>
				</div>
				<div class="btn-group" role="group" aria-label="...">
  					<button onclick="viewProfile(this)" id="cotto1234btn" type="button" class="btn btn-default">View profile</button>
				</div>
			</div>
		</div>	
	</div>
</div>

<div id="view-profile">
	<div id="selected-user"></div>
	<div id="map"></div>
	<div id="chart_div"></div>
</div>


