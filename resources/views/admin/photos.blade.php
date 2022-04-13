@extends('layouts/admin')

@section('css')
    <style type="text/css">
        .dropbox {
			outline: 2px dashed grey; /* the dash box */
			outline-offset: -10px;
			background: lightcyan;
			color: dimgray;
			padding: 10px 10px;
			min-height: 200px; /* minimum height */
			position: relative;
			cursor: pointer;
		}

		.input-file {
			opacity: 0; /* invisible but it's there! */
			width: 100%;
			height: 200px;
			position: absolute;
			cursor: pointer;
		}
		.dropbox:hover {
			background: lightblue; /* when mouse over to the drop zone, change color */
		}
        .activv, .top-text:hover {
            font-size: 20px;
            margin: 0.5em;
		}
        .top-link{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }
        .top-link-inner{
            display: flex;
            flex-direction: row;
            font-size: 12px;
        }
		.dropbox p {
			font-size: 1.2em;
			text-align: center;
			padding: 50px 0;
		}
        .icons {
            transform: scale(1.5);
        }
        .fa-trash {
            color: red;
        }
        
    </style>
@stop

@section('content')

 <!-- Begin Page Content -->
 <div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Products-Gallery 
                <a href="{{url('admin/product/create_photo')}}" class="btn btn-sm btn-primary dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Add Photo
                </a>
                @include('layouts/admin/photos_header')
                <div class="top-link">
                    <div class="top-link-inner" style="display: flex; flex-direction: row;">
                        <span style="display: flex; flex-direction: column;">
                            <a href="#" class="top-text activv">Add Photo(s) to Product</a>
                         </span>
                        <a href="#" class="top-text ml-5">Add Photo(s) to Slides</a>
                    </div>
                    
                    <a href="#" class="btn btn-success btn-sm">Save</a>
                </div>
                <select>
                    <option value="Select Product">Select Product</option>
                    <option value="Evening Gown">Evening Gown</option>
                    <option value="Casuals">Casuals</option>
                </select>

                 <!-- Modal Begins-->

                 <div class="dropdown col-md-12 row" style="width:100%; margin-left:-4em;">
                        
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="width:100%;">
                        {!! Form::open(['url' => "admin/photo/add",'method' => 'post', 'files' => true, 
                            'class'=>'form-horizontal', 'onsubmit'=>'return save();'])
                        !!}
                        @if(empty($product))
                            <div id="app" class="form-group row">
                                <p class="col-12">Add Product Photos</p>
                                
                                <p v-if="photoError != ''" class="col-12 alert alert-danger">@{{photoError}}</p>
                                <div class="dropbox col-8">
                                    <div id="photos">
                                        <input type="file" multiple name="photos[]" class="input-file" accept="image/*">
                                    </div>
                                    
                                    <p v-if="isInitial">
                                        Drag your file(s) here to begin<br> or click to browse 
                                    </p>
                                    
                                    <div v-else>
                                        <img v-for="f in uploadedFiles" width="120" height="100" :src="f.photo" style="margin-right: 1%" /> 
                                    </div>
                                </div>
                                <div class="col-4">
                                    <p v-if="!isInitial" v-for="f in uploadedFiles" :key="f.name" style="font-size:0.8em; display: flex; flex-direction: row">
                                        @{{f.name}}
                                        <a href="javascript:void(0)" class="col-md-2" @click="removePhoto(f.name)" style="color:red">X</a>
                                    </p>
                                </div>
                            </div>
                            <input type="hidden" name="deleted_photos" />
                            <input type="hidden" name="edit" value="0" />
                        @else
                            <input type="hidden" name="edit" value="1" />    
                        @endif
                        <div class="form-group">
                            {{ Form::submit(__('Save'), array('class'=>'form-control  mt-4 btn btn-primary'))}}
                        </div>
                    {!! Form::close() !!}
                        </div>
                    </div>
                    <!-- Modal Ends-->
            </h6>
        </div>
        <div class="card-body">
            @include('inc.message')
            <div class="row">
                @if($photos->count() > 0)
                    @foreach($photos as $photo)
                        <div class="col-3">
                            <span>
                                <img alt="" style="width:100%; height:15em; object-fit: cover; padding-bottom: 1em;" src="{{$photo->file->secure_url}}" />
                            </span>
                            <div class="container" style="display: flex; justify-content: space-between;">
                                <span class="icons">
                                    <input type="checkbox" id="" name="">
                                </span>
                                <span class="icons">
                                    <a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else 
                    No unattached photos
                @endif
                        
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@stop

@section('js')
    <script type="application/javascript">
        $('.dropdown-menu').on('click', function(event){
            var events = $._data(document, 'events') || {};
            events = events.click || [];
            for(var i = 0; i < events.length; i++) {
                if(events[i].selector) {

                    //Check if the clicked element matches the event selector
                    if($(event.target).is(events[i].selector)) {
                        events[i].handler.call(event.target, event);
                    }

                    // Check if any of the clicked element parents matches the 
                    // delegated event selector (Emulating propagation)
                    $(event.target).parents(events[i].selector).each(function(){
                        events[i].handler.call(this, event);
                    });
                }
            }
            event.stopPropagation(); //Always stop propagation
        });
        function save()
        {
            if(app.photos.length <= 0) {
                app.photoError = "Please add atleast one photo";
                console.log(app.deletedPhotos);
                setInterval(()=>{ app.photoError = ''; }, 5000);
                return false;
            }else{
                $('input[name=deleted_photos]').val(app.deletedPhotos);
                console.log(app.deletedPhotos);
                return true;
            }
            return true;
        }
        var app = new Vue({
			el: '#app',             
			computed: {
				isInitial() {
					return this.photos.length == 0;
				}
			},
			data: {
				photos: [],
                uploadedFiles: [],
                uploadError: null,
                currentStatus: null,
                uploadFieldName: 'photos',
                photoError: '',
                deletedPhotos: [],
            },
            methods: {
                removePhoto(pix) {
                    this.deletedPhotos.push(pix);
                    console.log('remove Photo');
                    var n = 0;
                    this.photos.forEach((photo, k)=>{
                        if(photo.name==pix) {
                            console.log('delete ',pix);
                            this.photos.splice(n, 1);
                        }
                        n = n + 1;
                    })
                    var n = 0;
                    this.uploadedFiles.forEach((file, k)=>{
                        if(file.name==pix) {
                            this.uploadedFiles.splice(n, 1);
                        }
                        n = n + 1;
                    })
                    if(this.photos.length < 6) {
                        this.photoError = "";
                    }
                },
                filesChange(fieldName, fileList) {
                    this.photoError = "";
                    // handle file changes
                    console.log('photos: ',fileList);
                    if(fileList.length > 0 && this.photos.length < 6) {
                        var self = this;
                        var rejectedPhotos = '';
                        Array.from(fileList).forEach((file, key)=> {
                            if(file && this.photos.length < 6) {
                                //check if there are photos that has been deleted
                                if(this.deletedPhotos.length > 0) {
                                    //loop through the deleted photos to know if the new photo added is the same as a deleted photos and if so, remove it from the array
                                    var n = 0;
                                    this.deletedPhotos.forEach((p, k2)=>{
                                        if(p==file.name) {
                                            this.deletedPhotos.splice(n, 1);
                                        }
                                        n = n + 1;
                                    })
                                }
                                if(this.photos.length > 0) {
                                    
                                    var exists = false;
                                    this.photos.forEach((f, k) =>{
                                        if(file.name == f.name) {
                                            exists = true;
                                        }
                                    })
                                    if(!exists) {
                                        const reader = new FileReader
                                        reader.onload = e => {
                                            var image = new Image();
                                            image.src = e.target.result;
                                            image.onload = function() {
                                                // access image size here 
                                                if(this.width < 500 || this.height < 400) {
                                                    self.deletedPhotos.push(file.name);
                                                    rejectedPhotos = rejectedPhotos+file.name+', ';
                                                    self.photoError = rejectedPhotos+' Must have width of at least 500pixels and height 400pixels';
                                                    setInterval(()=>{ self.photoError = ''; }, 7000);
                                                }else{
                                                    self.photos.push(file);
                                                    self.uploadedFiles.push({photo:e.target.result, name:file.name});
                                                }
                                            };
                                        }
                                        reader.readAsDataURL(file);
                                    }else{
                                        console.log('photo exists');
                                    }
                                }else{
                                    const reader = new FileReader;
                                    reader.onload = e => {
                                        var image = new Image();
                                        image.src = e.target.result;
                                        image.onload = function() {
                                            // access image size here 
                                            if(this.width < 500 || this.height < 400) {
                                                self.deletedPhotos.push(file.name);
                                                rejectedPhotos = rejectedPhotos+file.name+', ';
                                                self.photoError = rejectedPhotos+' Must have width of at least 500pixels and height 400pixels';
                                                setInterval(()=>{ self.photoError = ''; }, 7000);
                                                console.log('width: '+this.width+' height: '+this.height);
                                            }else{
                                                self.photos.push(file);
                                                self.uploadedFiles.push({photo:e.target.result, name:file.name});
                                            }
                                        };
                                    }
                                    reader.readAsDataURL(file)
                                }
                            }else if(this.photos.length >= 6) {
                                this.photoError = "Maximum Number of Photos that you can upload at once reached";
                            }
                        })
                        /**/
                    }else if(this.photos.length >= 6) {
                        this.photoError = "Maximum Number of Photos that you can upload at once reached";
                    }
                }
            },

        });

        $(document).ready(function() {
            //To enable adding more photos after initial multiple selections
            $(document).on('change', '.input-file', function(e) {
                app.filesChange(e.target, e.target.files);
                this.style.display = "none";
                $('#photos').append(`<input type="file" multiple name="photos[]" class="input-file" accept="image/*">`);
            })

            var Options = '';
            $('#collections :selected').each(function(e) {
                Options += `<option class="col-12" value="${this.value}">${this.text}</option>`
            })
            $('#selected-collection').html(Options);

            var Options2 = '';
            $('#sizes :selected').each(function(e) {
                Options2 += `<option class="col-12" value="${this.value}">${this.text}</option>`
            })
            $('#selected-size').html(Options2);

            $("select[multiple] option").mousedown(function () {
                var selectOptions = '';
                var $self = $(this);            
                var id = $(this).parent().attr('id');
                var id2 = $(this).parent().data("id");
                if ($self.attr("selected")) {                
                    $self.removeAttr("selected", "");
                }
                else {
                    $self.attr("selected", "selected");
                }
                $("#"+id+" :selected").each(function() {
                    selectOptions += `<option class="col-12" value="${this.value}">${this.text}</option>`
                });
                $('#'+id2).html(selectOptions);

                return false;            
            });
        })
    </script>
@stop
