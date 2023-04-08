<template>

    <div class=" gx-5" >



        <p v-if="error !== ''" class="text-danger">{{ error }}</p>

        <table class="">
            <tr>
                <td><p class="fw-bold text-success">Сеть:</p></td>
                <td><p class="fw-bold ">{{$route.query.name}}</p></td>
                <td></td>
            </tr>


            <tr >
                <td ><p class="fw-bold text-success">Адреса</p></td>
                <td class="table-info"></td>
                <td></td>
            </tr>


            <tr v-for="ip in ips">
                <td>{{ip.status}}</td>
                <td><p class="fw-bold text-primary">{{ip.ip}}</p></td>
                <td><button type="button " class="btn btn-danger" @click.prevent="dellIp(ip.id)"> Удалить </button></td>
                <td>
                    <input :class="ip.status == 'reserved' ? 'd-none' : '' " type="text" class="form-control" v-model="comment[ip.id]" placeholder="коммент">
                    <p :class="ip.status == 'free' ? 'd-none' : 'fw-bold text-warning' " >{{ip.comment}}</p>
                </td>
                <td>
                    <a :class="ip.status == 'reserved' ? 'd-none' : 'btn btn-warning' "  @click.prevent="freezeIp(ip.id)"> Заморозить </a>
                    <a :class="ip.status == 'free' ? 'd-none' : 'btn btn-success' " @click.prevent="unFreezeIp(ip.id)"> Разморозить </a>
                </td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td><input type="text" class="form-control " v-model="ipAddress" placeholder="Адрес">
                </td>
                <td>
                    <a class="btn btn-success" @click.prevent="addIp"> Добавить </a>

                </td>

            </tr>

        </table>
        <p class="fw-bold ">Резервировано: {{reservedId}}</p>
        <p class="fw-bold ">Свободно: {{freeId}}</p>

    </div>

</template>

<script>
export default {
    name: "EditComponent",
    data(){
        return{
            webId:'',
            error:'',
            ipAddress:'',
            ips:[],
            comment:[],
            freeId:null,
            reservedId:null

        }
    },
    methods:{
            addIp(){

                axios.post('api/addips', {webid:this.webId, ip:this.ipAddress})
                    .then( res =>{

                        this.error = ''
                        this.ipAddress = ''
                        this.getIps()

                    })
                    .catch(error=>{

                        this.error = error.response.data.message

                    })

            },

           getIps(){
                axios.get('api/getips?id='+this.webId)
                    .then( res =>{

                        this.error = ''
                        this.ips = res.data[0].ip
                        this.freeId = this.ips.filter(el => el.status === 'free').length
                        this.reservedId = this.ips.filter(el => el.status === 'reserved').length

                    })
                    .catch(error=>{

                        this.error = error.response.data.message

                    })
            },
            dellIp(id){
                axios.delete('api/delip/'+id)

                    .then( res =>{
                        this.error = ''
                        this.getIps()

                    })
                    .catch(error=>{

                        this.error = error.response.data.message

                    })

            },
            freezeIp(id){

                axios.put('api/freeze',{id:id,comment:this.comment[id]})
                    .then( res =>{

                        this.error = ''
                        this.getIps()

                    })
                    .catch(error=>{

                        this.error = error.response.data.message

                    })

            },
           unFreezeIp(id){

               axios.put('api/unfreeze',{id:id})
                   .then( res =>{

                       this.error = ''
                       this.getIps()

                   })
                   .catch(error=>{

                       this.error = error.response.data.message

                   })

           }

    },

    mounted() {

       this.webId = this.$route.query.id

       this.getIps()


    }
}
</script>

<style scoped>

</style>
