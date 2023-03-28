<template>
    <div class="carousel">
        <div class="carousel-inner">
            <carousel-indicators
                v-if="indicators"
                :total="slides.length"
                :current-index="currentSlide"
                @switch="switchSlide($event)"
            ></carousel-indicators>
            <carousel-item
                v-for="(slide, index) in slides"
                :slide="slide"
                :key="`item-${index}`"
                :current-slide="currentSlide"
                :index="index"
                :direction="direction"
                @mouseenter="stopSlideTimer"
                @mouseout="startSlideTimer"
            ></carousel-item>
            <carousel-controls
                v-if="controls"
                @prev="prev"
                @next="next"
            ></carousel-controls>
        </div>
    </div>
</template>

<script>
import CarouselItem from "./CarouselItem.vue";
import CarouselControls from "./CarouselControls.vue";
import CarouselIndicators from "./CarouselIndicators.vue";

export default {
    props: {
        slides: {
            type: Array,
            required: true,
        },
        controls: {
            type: Boolean,
            default: false,
        },
        indicators: {
            type: Boolean,
            default: false,
        },
        size: {
            type: String,
        },
        interval: {
            type: Boolean,
            default: false,
        },
        interval_val: {
            type: Number,
            default: 5000,
        },
    },
    components: { CarouselItem, CarouselControls, CarouselIndicators },
    data: () => ({
        currentSlide: 0,
        slideInterval: null,
        direction: "right",
        // size: props.size,
    }),
    methods: {
        setCurrentSlide(index) {
            this.currentSlide = index;
        },
        prev(step = -1) {
            const index =
                this.currentSlide > 0
                    ? this.currentSlide + step
                    : this.slides.length - 1;
            this.setCurrentSlide(index);
            this.direction = "left";
            this.startSlideTimer();
        },
        _next(step = 1) {
            const index =
                this.currentSlide < this.slides.length - 1
                    ? this.currentSlide + step
                    : 0;
            this.setCurrentSlide(index);
            this.direction = "right";
        },
        next(step = 1) {
            this._next(step);
            this.startSlideTimer();
        },
        startSlideTimer() {
            this.stopSlideTimer();
            if (this.interval) {
                this.slideInterval = setInterval(() => {
                    this._next();
                }, this.interval_val);
            }
        },
        stopSlideTimer() {
            clearInterval(this.slideInterval);
        },
        switchSlide(index) {
            const step = index - this.currentSlide;
            if (step > 0) {
                this.next(step);
            } else {
                this.prev(step);
            }
        },
    },
    mounted() {
        this.startSlideTimer();
    },
    beforeUnmount() {
        this.stopSlideTimer();
    },
};
</script>

<style scoped>
.carousel {
    @apply flex items-center w-[v-bind("size+'px'")] h-[v-bind("size*0.5+'px'")] w-full justify-center;
}
.carousel-inner {
    @apply relative w-[v-bind("size+'px'")] h-[v-bind("size*0.5+'px'")] overflow-hidden;
    /* width: 100%; */
}
</style>
