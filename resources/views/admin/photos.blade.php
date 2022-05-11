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
            </h6>
                @include('layouts/admin/photos_header')
                <div class="top-link">
                    <div class="top-link-inner" style="display: flex; flex-direction: row;">
                        <span style="display: flex; flex-direction: column;">
                            <a href="#" class="top-text activv" onclick="switchCategory('product')">Add Photo(s) to Product</a>
                         </span>
                        <a href="#" class="top-text ml-5" onclick="switchCategory('slide')">Add Photo(s) to Slides</a>
                    </div>
                    
                    <a href="#" class="btn btn-success btn-sm" onclick="addPhotos()">Save</a>
                </div>
                <select name="product-id">
                    <option value="">Select Product</option>
                    @if($products->count() > 0)
                        @foreach($products as $product) <option value="{{$product->id}}">{{$product->name}}</option> @endforeach
                    @endif
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
            
       
                </div>
                 <!-- Modal Ends-->

        <div class="card-body">
            @include('inc.message')
            <div class="row">
                <p id="loading" class="d-none mb-3" style="height: 4em; border: 1px blue solid;"><img src="{{asset('/assets/img/loading-spinner.gif') }}" style="position:absolute; transform: scale(0.5); height:14em; left:40%; top:8.5em; border-radius: 50%;" alt="image"></p>
                <div id="errors" class="d-none">
                    <span class="alert alert-danger"></span>
                        </div>
                <div id="dropboxPhotos" class="row mt-5"></div>
                
                <input type="hidden" value="{{$email}}" name="email" />      
            </div>
        </div>
    </div>
    <input type="text" name="category" value="product"/>
</div>
<!-- /.container-fluid -->
@stop

@section('js')
    <script type="application/javascript">

        var checkedPhotosArr = [];
        
        $(document).on('click', '.checkbox', function(e){
            console.log('clicked');
            if(this.checked == true) {
                let file = this.value;
                let thumb = $(this).data("thumb");
                let url = $(this).data("url");
                let size = $(this).data("size");
                checkedPhotosArr.push({file, thumb, url, size});
                console.log(checkedPhotosArr);
            } else {
                    // REMOVE VALUE FROM ARRAY WHEN IT IS UNCHECKED
                checkedPhotosArr = checkedPhotosArr.filter(e => e !== this.value);
            }
        });

        function addPhotos()
        {
            //Adding selected photos to their corresponding categories
            //console.log('adding photos');
            //console.log(checkedPhotosArr);
            let category = $('input[name=category]').val();
            //if(category=='product') {
            let id = 0;
            let errorMsg = '';
            switch(category) {
                case 'product' : id = $('select[name=product-id]').val(); errorMsg = "please choose a product"; break;
                case 'collection' : id = $('select[name=collection-id]').val(); errorMsg = "please choose a collection"; break;
            }
            if(id != '') {
                //Add photos
                let url = "{{url('admin/photo/add_to_category')}}";
                var token = $('meta[name="csrf-token"]').attr('content');
                let formData =  {photos: checkedPhotosArr, id: id, category: category, _token: token};
                console.log('formdata: ',formData);
                    
                axios.post(url, formData)
                .then((res) => {
                    console.log('response: ',res);
                    if(res.status == 200) {
                        checkedPhotosArr.forEach(({ file }) => {
                            file = getFilenumber(file);
                            $('#'+file).remove();
                        })
                    }
                })

            }else{
                console.log(errorMsg);
                $('#errors span').html('Error: '+errorMsg);
                $('#errors').removeClass('d-none');
            }
            //}
        }

        function switchCategory(category)
        {
            console.log('switch category');
            $('input[name=category]').val(category);
        }

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

        function isLoading(status)
        {
            (status) ? $('#loading').removeClass('d-none') : $('#loading').addClass('d-none');
        }
        function getFilenumber(file) {
            let arr = file.split('_');
            let filename = arr[arr.length-1];
            let filenameArr = filename.split('.');
            return filenameArr[0];
        }
        $(document).ready(function() {
            //When document loads
            isLoading(true);
            //make a POST Request using axios to get dropbox photos

            let url = "{{url('admin/photo/get_dropbox_photos')}}";
            var token = $('meta[name="csrf-token"]').attr('content');
            let email = $('input[name=email]').val();
            let formData =  {email: email, _token: token};
            //console.log(`email: ${email} token: ${token}`);
            axios.post(url, formData)
            .then((res) => {
                isLoading(false);
                console.log('result ', res);
                if(res.status == 200) {
                    console.log('photos: ',res.data.photos);
                    let setWidth = 150;
                    if(Object.keys(res.data.photos).length > 0) {

                        //loop through the photos
                        let photoContent = '';
                        let imgBinaryPrefix = 'data:image/jpg;base64,';
                        res.data.photos.forEach((photo) => {
                            let file = getFilenumber(photo.file);
                            console.log('file: ', file);
                            photoContent += `
                            <div class="col-3" id="${file}">
                                <span>
                                    <img alt="" style="width:100%; height:24em; border-radius:10px; transform: scale(0.7); object-fit: cover;" class="lazyload img-back" src="${imgBinaryPrefix+photo.thumb}" />
                                </span>
                                <div class="container" style="display: flex; justify-content: space-around; padding-right:2em; padding-left:2em">
                                    <span class="icons">
                                        <input type="checkbox" id="" class="checkbox" name="" value="${photo.file}" data-thumb=",${photo.thumb}" data-url="${photo.url}" data-size="${photo.size}">
                                    </span>
                                    <span class="icons">
                                        <a href="#"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                    </span>
                                </div>
                            </div>
                            `;
                        })
                        $('#dropboxPhotos').html(photoContent);
                    }else{
                        //The photos is empty
                        $('#dropboxPhotos').html('<p> No photos available </p>');
                    } 
                }else{
                    console.log('error:', res.data.message);
                }
            })
            .catch((error) => {
                isLoading(false);
                console.log("An error occured while trying to perform the operation "+error.message);
                $('#dropboxPhotos').html('<p class="alert alert-danger">Oops!.. An error occured while attempting to fetch your photos, Please reload.. If error persists, contact the Administrator</p>');
                throw error;
            });

            //console log what we return
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
