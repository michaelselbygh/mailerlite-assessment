<template>
  <div>
    <div class="container" v-if="loading">loading...</div>

    <div class="container" v-if="!loading">
      <b-card v-if="account" :header="'Welcome, ' + account.name" class="mt-3">
        <b-card-text>
          <div>
            Account: <code>{{ account.id }}</code>
          </div>
          <div>
            Balance:
            <code
              >${{ account.balance }}</code
            >
          </div>
        </b-card-text>
        <b-button size="sm" variant="success" @click="show = !show"
          >New payment</b-button
        >

        <b-button
          class="float-right"
          variant="danger"
          size="sm"
          nuxt-link
          to="/"
          >Logout</b-button
        >
      </b-card>

      <b-card class="mt-3" header="New Payment" v-show="show">
        <b-form @submit="onSubmit">
          <b-form-group id="input-group-1" label="To:" label-for="input-1">
            <b-form-input
              id="input-1"
              size="sm"
              v-model="payment.to"
              type="number"
              required
              placeholder="Destination ID"
            ></b-form-input>
          </b-form-group>

          <b-form-group id="input-group-2" label="Amount:" label-for="input-2">
            <b-input-group prepend="$" size="sm">
              <b-form-input
                id="input-2"
                v-model="payment.amount"
                type="number"
                required
                placeholder="Amount"
              ></b-form-input>
            </b-input-group>
          </b-form-group>

          <b-form-group id="input-group-3" label="Details:" label-for="input-3">
            <b-form-input
              id="input-3"
              size="sm"
              v-model="payment.details"
              required
              placeholder="Payment details"
            ></b-form-input>
          </b-form-group>

          <b-button type="submit" size="sm" variant="primary">Submit</b-button>
        </b-form>
      </b-card>

      <b-card class="mt-3" header="Payment History">
        <b-table striped hover 
        :items="transactions" 
        :fields="fields"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
        ></b-table>
      </b-card>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";
import Vue from "vue";

export default Vue.extend({
  data() {
    return {
      show: false,
      payment: {},
      apiBaseUrl: 'http://ml-api.local',
      account: null,
      transactions: null,

      loading: true,
      sortBy: 'id',
      sortDesc: 'true',
      fields: [
          {
            key: 'id',
            sortable: true
          },
          {
            key: 'from',
            sortable: false
          },
          {
            key: 'to',
            sortable: true,
          },
          {
            key: 'details',
            sortable: true,
          },
          {
            key: 'amount',
            sortable: true,
          },
          {
            key: 'processed',
            sortable: true,
          }
        ],
    };
  },

  mounted() {
    const that = this;

    var response = axios.get(`${this.apiBaseUrl}/api/accounts/${this.$route.params.id}/transactions`)
      .then((response) => {
        this.transactions = response.data.transactions;
        this.account = response.data.account;
        if (this.transactions && this.account) {
          this.loading = false;
        }
        
      });
  },

  methods: {
    async onSubmit(evt) {
      evt.preventDefault();

      var response = await axios.post(
        `${this.apiBaseUrl}/api/accounts/${
          this.$route.params.id
        }/transactions`,

        this.payment
      );

      if (response.data.code == 200) {
          this.$izitoast.success({
            message: 'Transaction processed successfully'
          });
          this.transactions = response.data.transactions;
          this.account = response.data.account;
        }else{
          this.$izitoast.error({
            message: response.data.message
          });
        }
      this.payment = {};
      this.show = false;
    }
  }
});
</script>
