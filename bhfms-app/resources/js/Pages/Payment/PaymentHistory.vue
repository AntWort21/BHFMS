<script setup>
import { ref, Link } from 'vue';
import PaymentHistoryTab from '../../Shared/Payment/PaymentHistoryTab.vue';
import Header from '../../Shared/Header.vue';
import Footer from '../../Shared/Footer.vue';
import DetailBoxTenant from '../../Shared/Payment/DetailBoxTenant.vue';
defineProps({
  userRole: Number,
  paymentList: Array,
})

const csrfToken = document.getElementsByName("csrf-token")[0].content; 
const detailBox = ref(false);
const detailInvoice = ref([]);
const price = ref('');

let showDetail = (invoice_id) => {
  fetch('getInvoiceData', {
    method: 'POST',
    headers: {
      "X-CSRF-Token": csrfToken,
    },
    body: JSON.stringify({
      invoice_id: invoice_id,
    })
  }).then((response) => response.json())
    .then((data) => {
      console.log(data)
      detailInvoice.value = data[1];
      price.value = data[0];
    })
  detailBox.value = true;
}

let closeDetail = () => {
  detailBox.value = false;
  detailInvoice.value = [];
  price.value = '';
}
</script>

<template>
    <Header />
    <div class="z-10 my-4" >
        <section class="flex text-center align-middle mx-10">
            <div class="font-bold self-center">
                <h3>
                    Payment List
                </h3>
            </div>
        </section>
        <section class="mx-2 my-5">
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