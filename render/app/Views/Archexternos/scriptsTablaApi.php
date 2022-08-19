<script type="application/javascript">
$(document).ready(function() {

    var url = "https://jsonplaceholder.typicode.com/comments";
    new Vue({
        el: '#app',
        vuetify: new Vuetify(),
        data() {
            return {
                search: '',
                columnas: [{
                        text: 'IDENTIFICACION',
                        value: 'id',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'NOMBRE',
                        value: 'name',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'EMAIL',
                        value: 'email',
                        class: 'blue accent-2'
                    },
                    {
                        text: 'Actions',
                        value: 'actions',
                        sortable: false,
                        class: 'blue accent-2'
                    }
                ],
                articulos: [],
            }
        },
        created() {
            axios.get(url).then(response => {
                this.articulos = response.data;
            });

        },
        methods: {
            deleteItem(item) {
                this.articulos.splice(this.articulos.indexOf(item), 1);
            },
        }
    })



});
</script>

<style>
.mover {
    float: right;
}
</style>