<template>
    <div>
        <b-container fluid class="bg-dark border border-light p-5 text-white" style="background-image:url('background-image.png'); background-repeat:no-repeat; background-size:cover; background-color:rgba(0, 0, 0, 0.5);">
            <b-row class="p-5 d-flex border border-light">
                <b-col col="8" order="1" md="8" order-md="1" sm="12" order-sm="2" class="p-2">
                    <p class="glow" data-text="MOST POPULAR IMAGE" style="color:#cfe2f3; font-size:4em"><strong>MOST POPULAR IMAGE</strong></p>
                    <br>
                    <p id="desc" style="font-size:2em; font-style:italic">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                </b-col>
                <b-col col="8" order="3" md="3" order-md="3" sm="12" order-sm="3" class="p-2">
                    <div>   
                        <p style="font-size:3em;"><strong>{{most_popular_image.name}}</strong></p>
                        <h2>Viewed for <strong style="color:red;">{{most_popular_image.requestCount}} times</strong></h2>
                        <b-button size="lg" variant="primary" @click="setImageModal(most_popular_image)" v-b-modal.imageModal><font-awesome-icon icon="fa-solid fa-maximize" /> Maximize</b-button>
                        <b-button size="lg" variant="light" @click="downloadImage('most_popular')"><font-awesome-icon icon="fa-solid fa-download" /> Download</b-button>
                    </div>
                </b-col>
                <b-col col="4" order="2" order-md="2" order-sm="2" md="4" sm="12">
                    <b-img style="width:80%" id="most_popular" thumbnail fluid :src = "most_popular_image.url" :alt = "most_popular_image.name"></b-img>
                </b-col>
            </b-row>
        </b-container>
        <div class="container">
            <div class="row">
                <p style="text-align:center; font-size:3em;"><strong>TOP 10 VIEWED</strong></p>
                <div v-for="(image,index) in top_viewed" class="col-md-3 col-sm-12 mb-5">
                    <div class="card" style="width: 100%; ">
                    <img :id="`img_${index}`" style="width: 100%;object-fit: fill;" :src = "image.url" class="card-img-top" alt="...">
                    <div class="card-footer">
                        <p class="card-text"><strong>{{image.name}} <font-awesome-icon icon="fa-solid fa-medal" v-if="index<3" size="lg" :style="{color:medalColor[index]}" /></strong></p>
                        <p class="card-text">Viewed for <strong>{{image.requestCount}} times</strong></p>
                        <b-button variant="outline-primary" @click="setImageModal(image)" v-b-modal.imageModal><font-awesome-icon icon="fa-solid fa-maximize" /></b-button>
                        <b-button variant="outline-primary" @click="downloadImage('img_'+index)"><font-awesome-icon icon="fa-solid fa-download" /></b-button>
                    </div>
                    </div>
                </div>
            </div>
            <div class="container mt-5">
                <div>
                <b-modal id="imageModal" size="lg" hide-footer="true" :title="expandedImage.name">
                    <p class="my-4"><img class="w-100" :src="expandedImage.url"/></p>
                </b-modal>
            </div>    
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                most_popular_image : [],
                top_viewed : [],
                expandedImage:{
                    name:'',
                    url:''
                },
                medalColor:['gold','silver','#CD7F32']
            }
        },
        mounted() {
            this.axios
                .get('http://127.0.0.1:8000/api/image/popular')
                .then(response => {
                    this.most_popular_image = response.data[0];
                });
            this.axios
                .get('http://127.0.0.1:8000/api/image/mostviewed')
                .then(response => {
                    this.top_viewed = response.data;
                });
        },
        methods:{
            setImageModal(expandedImage){
                this.expandedImage = expandedImage;
            },
            async downloadImage(id) {
                let image = document.getElementById(id);
                let src = image.src;
                this.axios({
                    url:src,
                    method:'get',
                    responseType:'blob'
                }).then((response)=>{
                    let fileUrl = window.URL.createObjectURL(new Blob([response.data]));
                    let file = document.createElement('a');
                    file.href = fileUrl;
                    file.setAttribute('download',src.substring(src.lastIndexOf('/')+1));
                    document.body.appendChild(file);
                    file.click();
                });
            },
        }
    }
</script>
