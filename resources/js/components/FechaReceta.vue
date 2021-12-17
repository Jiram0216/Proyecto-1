<template>
    <!-- Mostrando la fecha en pantalla a traves de v-text. -->
    <span v-text="formatearFecha"></span>
</template>


<script>
    // Logica de obtener la fecha y darle formato.
    export default {
        props: ['fecha'],
        computed: {
            formatearFecha(){
                // Obteniendo la fecha desde show.blade.php y dandole formato.
                return moment(this.fecha).locale('es').format('DD [de] MMMM [del] YYYY');
            }
        }
        // Mostrando la fecha a traves de la consola del navegador
        // mounted() {
        //     console.log('La fecha es: ', this.fecha);
        // }
    }
</script>