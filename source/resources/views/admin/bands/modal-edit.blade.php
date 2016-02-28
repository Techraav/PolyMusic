<!-- Modal -->
<div class="modal fade" id="modalEdit" role="dialog">
	<div class="modal-dialog">

  	<!-- Modal content-->
      	<div class="modal-content">
       	 	<div class="modal-header">
          		<button type="button" class="close" data-dismiss="modal">&times;</button>
          		<h4 id="modal-title" class="modal-title">Modifier le groupe</h4>
        	</div>


	        <form id="edit-form" class="form modal-form" method="post" action="{{ url('admin/bands/edit') }}">
	        {!! csrf_field() !!}
	        <br />
			<div class="row">
				<input hidden name="band_id" id="band_id" value="" />		        
				<div class="col-lg-10 col-lg-offset-1">
					<div class="form-group">
						<label class="control-label">Nom :</label>
						<input required class="form-control" type="text" name="name" id="name" placeholder="Nom du groupe" value=""/>
					</div>
				</div>

				<div class="col-lg-10 col-lg-offset-1">
					<div class="form-group">
						<label class="control-label">Manager :</label>
						<input required disabled name="manager" id="manager" class="form-control" value=""/>
					</div>
				</div>

				<div class="col-lg-10 col-lg-offset-1">
					<div class="form-group">
						<label class="control-label">  Groupe validé :
							<input type="checkbox" class="checkbox" name="validated" id="validated" />
						</label>
					</div>
				</div>

				<input hidden required name="user_id" id="user_id" value="" />

				<div class="col-lg-10 col-lg-offset-1">
					<div class="form-group">
						<label class="control-label">infos :</label>
						<textarea required class="form-control" name="infos" id="infos"></textarea>
					</div>
				</div>


			</div>
        	<span align="center" class="help-block"><i>Pour modifier les membres du groupe, modifiez-le à partir de sa fiche de présentation.</i></span>
		    <br />

		        <div class="modal-footer">
		          	<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
		          	<button type="submit" class="btn btn-primary">Modifier	</button>
		        </div>
			</form>

   		</div>
	</div>
</div>