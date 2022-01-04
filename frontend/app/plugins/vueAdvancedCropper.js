import Vue from 'vue'
import { Cropper, Preview } from 'vue-advanced-cropper'
import 'vue-advanced-cropper/dist/style.css';

Vue.component('CropperPreview', Preview)
Vue.component('Cropper', Cropper)
