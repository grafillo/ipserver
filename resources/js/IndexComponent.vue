<template>

    <div class="w-50 text-right">
        <p><b>{{header}}</b></p>
        <p v-for="web in webs"><a :href="'/public/edit?id='+web.id+'&name='+web.name" class="link-primary">{{web.name}}</a>
            <button type="button " class="btn btn-danger" @click.prevent="dellWeb(web.id)"> Удалить </button>
        </p>
    </div>

    <p v-if="error !== ''" class="text-danger">{{ error }}</p>

    <div class="row gx-5 " v-if="webId ==='' ">
        <input type="text" class="form-control w-25" v-model="webName" placeholder="Название сети">
        <input @click.prevent="addWeb" class="btn btn-primary w-25"  placeholder="Создать">
    </div>


</template>

<script>
export default {
    name: "IndexComponent",

    data() {
        return{
          header:'',
            webs:[],
            webName:'',
            webId:'',
            error:''

       }
    },

    methods:{
        addWeb(){
            axios.post('api/addweb',{ name:this.webName})
                .then( res =>{

                    this.error = ''
                    this.$router.push({ path: '/public/edit',query: { id:res.data.id, name: res.data.name } })

                })
                .catch(error=>{

                    this.error = error.response.data.message

                })

        },
        dellWeb(id){
                axios.delete('api/delweb/'+id)
                    .then( res =>{

                        this.error = ''
                        this.getWeb()

                    })
                    .catch(error=>{

                        this.error = error.response.data.message

                    })

        },
        getWeb() {
            axios.get('api/getwebs')
                .then( res =>{

                    this.webs = res.data
                    if(this.webs.length ===0){
                        this.header = 'Нет ни одной сети'
                    }else {
                        this.header = 'Существующие сети:'
                    }

                })
                .catch(error=>{

                    this.error = ''
                    this.error = error.response.data.message

                })


        }

    },
    computed:{

    },
    mounted() {

        this.getWeb()

    }


}
</script>

<style scoped>

</style>
