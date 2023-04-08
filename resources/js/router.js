import {createRouter, createWebHistory} from 'vue-router';
import IndexComponent from "./IndexComponent.vue";
import EditComponent from "./EditComponent.vue";




export default createRouter({
    history:createWebHistory(),
    routes:[
        {
            path: '/public/index',
            component: IndexComponent,
            // props: route => ({ query: route.query.id })
        },
        {
            path: '/public/',
            component: IndexComponent,
            // props: route => ({ query: route.query.id })
        },
        {
            path: '/public/edit',
            component: EditComponent,
            props: route => ({ id: route.query.id, name:route.query.name })
        },

    ]

})
