<script setup>
import { ref, Link } from '@inertiajs/inertia-vue3';
import Vue from 'vue';
import PaymentHistoryTab from '../../Shared/Payment/PaymentHistoryTab.vue';
import Header from '../../Shared/Header.vue';
import Footer from '../../Shared/Footer.vue';
import DetailBoxTenant from '../../Shared/Payment/DetailBoxTenant.vue';
import { useScrollLock } from '@vueuse/core'
Vue.loadScript("https://unpkg.com/@vueuse/core");
defineProps({
  userRole: Number,
  paymentList: Array,
  detailInvoice: Array
})
const el = ref<HTMLElement | null>(null)
const isLocked = useScrollLock(el)
isLocked.value = false
</script>

<template>
    <Header/>
    <div class="z-10">
        <section class="flex justify-between text-center align-middle mx-10">
            <div class="font-bold self-center">
                <h3>
                    Payment List
                </h3>
            </div>
            <div class="flex flex-row">
                <button class="flex flex-row w-6 h-6 mr-5 text-base bg-blue-400 items-center font-bold justify-center text-white rounded-xl font-mono">
                    +
                </button>
                <h3 class="self-center">Add New Payment</h3>
            </div>
        </section>
        <section class="mx-2">
            <div class="flex justify-around text-center">
                <div class="w-1/4">
                    <h4>Status</h4>
                </div>
                <div class="w-1/4">
                    <h4>Date</h4>
                </div>
                <div class="w-1/4">
                    <h4 v-if="userRole==1">Tenant Name</h4>
                    <h4 v-else-if="userRole==2||3">Boarding House</h4>
                    <h4 v-else>Boarding House</h4>
                </div>
                <div class="w-1/4">
                </div>
            </div>
        </section>
        <section class="mx-2 my-3">
            <div v-for="(payment) in paymentList" class="flex justify-around text-center py-1">
                <PaymentHistoryTab
                :payment=payment
                @showDetail="showDetail" />
            </div>
        </section>
    </div>
    <DetailBoxTenant v-if="detailBox"
    :invoiceDetail=this.detailInvoice
    :price = this.price
    @closeDetail = "closeDetail" />
    <Footer />
</template>
<script>
    const csrfToken = document.getElementsByName("csrf-token")[0].content; 
    export default {
        data () {
            return {
                detailBox: false,
                detailInvoice: 0,
                price: '',
            }
        },
        methods: {
            showDetail(invoice_id){
                this.detailBox = true;
                isLocked.value = true;
                fetch('getInvoiceData', {
                    method: 'POST',
                    headers: {
                        "X-CSRF-Token": csrfToken,
                    },
                    body: JSON.stringify({
                        invoice_id : invoice_id,
                    })
                }).then((response) => response.json())
                .then((data)=>{
                    console.log(data)
                    this.detailInvoice = data[1];
                    this.price = data[0]
                })
                
            },
            closeDetail(){
                this.detailBox= false;
                this.detailInvoice= 0;
                this.price= '';
            }
        }
    }
</script>