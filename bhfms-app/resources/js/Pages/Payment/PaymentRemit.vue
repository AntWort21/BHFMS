<script setup>
import { ref } from 'vue';
import { Link } from '@inertiajs/inertia-vue3'
import Header from '../../Shared/Header.vue';
import Footer from '../../Shared/Footer.vue';
import DetailBoxTenant from '../../Shared/Payment/DetailBoxTenant.vue';
import PopUpInputText from '../../Shared/Payment/PopUpInputText.vue';
import PopUpInputImage from '../../Shared/Payment/PopUpInputImage.vue';
import PaymentRemitTab from '../../Shared/Payment/PaymentRemitTab.vue';
defineProps({
  userRole: Number,
  invoiceList: Object,
})

defineExpose({
  detailInvoice
});

const csrfToken = document.getElementsByName("csrf-token")[0].content; 
const detailBox = ref(false);
const detailInvoice = ref({
  invoice: [],
  price: 0,
  username: '',
  boardingName: ''
});

const popUpBoxText = ref(false);
const popUpBoxImage = ref(false);
const popUpDetail = ref({
  id: '',
  status: ''
})

let showDetail = (invoiceId) => {
  fetch('/getInvoiceData', {
    method: 'POST',
    headers: {
      "X-CSRF-Token": csrfToken,
    },
    body: JSON.stringify({
      invoice_id: invoiceId,
    })
  })
  .then((response) => response.json())
  .then((data) => {
    detailInvoice.value.price = convertAmount(data[0]);
    detailInvoice.value.invoice = data[1];
    detailInvoice.value.username = data[2];
    detailInvoice.value.boardingName = data[3];
  });

  detailBox.value = true;
}

let showPopUpText = (popUpData) => {
  popUpDetail.value.status = popUpData[0];
  popUpDetail.value.id = popUpData[1];
  popUpBoxText.value = true;
}

let showPopUpImage = (popUpData) => {
  popUpDetail.value.status = popUpData[0];
  popUpDetail.value.id = popUpData[1];
  popUpBoxImage.value = true;
}

const closeDetail = () => {
  detailBox.value = false;
  detailInvoice.value.price = 0;
  detailInvoice.value.invoice = [];
  detailInvoice.value.username = '';
  detailInvoice.value.boardingName = '';
}

const closePopUpText = () => {
  popUpBoxText.value = false;
  popUpDetail.value.id = '';
  popUpDetail.value.status = '';
}

const closePopUpImage = () => {
  popUpBoxImage.value = false;
  popUpDetail.value.id = '';
  popUpDetail.value.status = '';
}

let convertAmount = (amount) => {
    return new Number(amount).toLocaleString("id-ID");
}

</script>

<template>
    <Header />
    <div class="z-10 my-4 min-h-[75vh]">
        <section class="flex text-center align-middle mx-10">
            <div class="text-2xl font-semibold self-center">
              Remittance List
            </div>
        </section>
        <section class="mx-2 my-5">
            <div class="flex justify-around text-center">
                <div class="w-1/4">
                    <h4>Date</h4>
                </div>
                <div class="w-1/4">
                    <h4>Amount</h4>
                </div>
                <div class="w-1/4">
                    <h4>Bank and Account Number</h4>
                </div>
                <div class="w-1/4 flex flex-row">
                    <p class="w-1/3">Approve</p>
                    <p class="w-1/3">Reject</p>
                    <p class="w-1/3"></p>
                </div>
            </div>
        </section>
        <section class="mx-2 my-3">
            <div v-for="(invoice) in invoiceList.data" class="flex text-center py-1">
              <PaymentRemitTab
              :user-role=userRole
              :invoice=invoice
              @showDetail="showDetail"
              @showPopUpDeclined="showPopUpText"
              @showPopUpSuccessful="showPopUpImage"
              />
            </div>
        </section>
      <div class="my-4 flex justify-center">
        <Link
          :href="invoiceList.prev_page_url"
          v-if="invoiceList.prev_page_url"
          class="px-2 py-1 bg-gray-300 rounded mr-2">
            Previous
        </Link>
        <Link
            :href="invoiceList.next_page_url"
            v-if="invoiceList.next_page_url"
            class="px-2 py-1 bg-gray-300 rounded ml-2">
            Next
        </Link>
      </div>
    </div>
    <DetailBoxTenant v-if="detailBox"
    :invoiceDetail = detailInvoice.invoice
    :price = detailInvoice.price
    :username = detailInvoice.username
    :boarding-name= detailInvoice.boardingName
    :user-role = this.userRole
    @closeDetail = "closeDetail"/>

    <PopUpInputImage v-if="popUpBoxImage"
    :pop-up-name="'Accept Proof'"
    :value= popUpDetail.status
    :label-name= "'Reason'"
    :id= popUpDetail.id
    :link-pop="'updateTransferredStatus'"
    @closePopUp = "closePopUpImage"/>
    
    <PopUpInputText v-if="popUpBoxText" 
    :pop-up-name="'Declined Reason'"
    :value= popUpDetail.status
    :label-name= "'Reason'"
    :id= popUpDetail.id
    :link-pop="'updateTransferredStatus'"
    @closePopUp = "closePopUpText"/>
    <Footer />
</template>