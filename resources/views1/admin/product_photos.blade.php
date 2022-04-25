@extends('layouts/admin')

@section('css')
    <style type="text/css">
        .newPhoto { 
            margin-bottom: 2em;
        }
        .prodName{
            margin: 1em;
        }
        .icons {
            transform: scale(1.5);
            margin: 0 2em;
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
            <h6 class="m-0 font-weight-bold text-primary">Products-Gallery </h6>
                @include('layouts/admin/photos_header')
        </div>
        <div class="card-body">
            <h4 class="prodName">Ankara Gown</h4>

            @include('inc.message')
            <div class="row">
                @if($photos->count() > 0)
                    @foreach($photos as $photo)
                        <div class="col-3 newPhoto">
                            <span>
                                <img alt="" style="width:100%; height:15em; object-fit: cover; padding-bottom: 1em;" src="{{$photo->file->secure_url}}" />
                            </span>
                            <div class="container" style="display: flex; justify-content: space-between;">
                                <span class="icons">
                                    <input type="checkbox" id="" name="">
                                </span>
                                <span class="icons">
                                    <a href="{{url('admin/photo/delete/'.$photo->id)}}"><i class="fa fa-trash" id="" aria-hidden="true"></i></a>
                                </span>
                            </div>
                        </div>
                    @endforeach
                @else 
                
                    No unattached photos
                 @endif
                        
            </div>
        </div>
        <div class="card-body">
            <h4 class="prodName">Petit Gown</h4>

            @include('inc.message')
            <div class="row">
                @if($photos->count() > 0)
                    @foreach($photos as $photo)
                        <div class="col-3 newPhoto">
                            <span>
                                <img alt="" style="width:100%; height:15em; object-fit: cover; padding-bottom: 1em;" src="{{$photo->file->secure_url}}" />
                            </span>
                            <div class="container" style="display: flex; justify-content: space-between;">
                                <span class="icons">
                                    <input type="checkbox" data-id="{{$photo->id}}" name="">
                                </span>
                                <span class="icons">
                                    <a href="{{url('admin/photo/delete/'.$photo->id)}}"><i class="fa fa-trash" id="" aria-hidden="true"></i></a>
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
