<template>
    <canvas class="l-users_chats" ref="users_charts"></canvas>
</template>

<script type="text/babel">
    import Vue from 'vue';
    import Chart from 'chart.js';
    import Component from 'vue-class-component'

    @Component({
        props: ['charts', 'title']
    })
    export default class UsersCharts extends Vue {
        mounted() {
            let options = {
                legend: {
                    position: 'right',
                    labels: {
                        boxWidth: 5,

                        usePointStyle: true
                    },

                },
                elements: {
                    center: {
                        text: 'Desktop',
                        color: '#36A2EB', //Default black
                        fontStyle: 'Helvetica', //Default Arial
                        sidePadding: 15 //Default 20 (as a percentage)
                    }
                }
            };
            Chart.pluginService.register({
                beforeDraw: function (chart) {
                    if (chart.config.options.elements.center) {
                        //Get ctx from string
                        let ctx = chart.chart.ctx;

                        //Get options from the center object in options
                        let centerConfig = {
                            text: chart.config.data.title,
                            color: '#36A2EB', //Default black
                            sidePadding: 15 //Default 20 (as a percentage)
                        };
                        let fontStyle = centerConfig.fontStyle || 'Arial';
                        let txt = centerConfig.text;
                        let color = centerConfig.color || '#000';
                        let sidePadding = centerConfig.sidePadding || 20;
                        let sidePaddingCalculated = (sidePadding / 100) * (chart.innerRadius * 2)
                        //Start with a base font of 30px
                        ctx.font = "30px " + fontStyle;

                        //Get the width of the string and also the width of the element minus 10 to give it 5px side padding
                        let stringWidth = ctx.measureText(txt).width;
                        let elementWidth = (chart.innerRadius * 2) - sidePaddingCalculated;

                        // Find out how much the font can grow in width.
                        let widthRatio = elementWidth / stringWidth;
                        let newFontSize = Math.floor(30 * widthRatio);
                        let elementHeight = (chart.innerRadius * 2);

                        // Pick a new font size so it will not be larger than the height of label.
                        let fontSizeToUse = (Math.min(newFontSize, elementHeight));

                        //Set font settings to draw it correctly.
                        ctx.textAlign = 'center';
                        ctx.textBaseline = 'middle';
                        let centerX = ((chart.chartArea.left + chart.chartArea.right) / 2);
                        let centerY = ((chart.chartArea.top + chart.chartArea.bottom) / 2);
                        ctx.font = (fontSizeToUse / 1.2) + "px " + fontStyle;
                        ctx.fillStyle = color;

                        //Draw text in center
                        fontSizeToUse = (fontSizeToUse / 1.8);
                        ctx.fillText(txt, centerX, (centerY + fontSizeToUse));
                        ctx.fillText(chart.config.data.total, centerX, (centerY - fontSizeToUse));
                    }
                }
            });

            // For a pie chart
            new Chart(this.$refs.users_charts, {
                type: 'doughnut',
                data: this.charts,
                options: options,
            });
        }

    }
</script>
<style scoped>
    .l-users_chats {
        max-width: 80vh;
        height: auto !important;
        margin: 0 auto;
    }

</style>