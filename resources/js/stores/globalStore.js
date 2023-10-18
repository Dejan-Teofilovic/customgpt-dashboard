import { defineStore } from 'pinia';
import axios from '@axios';
import { stringifyQuery } from 'vue-router';

const source={};
// = axios.CancelToken.source();

const useGlobalStore = defineStore('globalStore', {
  state: () => ({
    currentSelectedDailyBreakdown: 0,
    dateRange: "",
    totalQueryCount: null,
    avgResponseEndTime: null,
    avgResponseStartTime: null,
    avgQueryInputWord: null,
    avgQueryOutputWord: null,
    totalConversationCount: null,
    avgQueryPerConversation: null,
    avgTimePerConversation: null,
    dailyBreakdownQuery: null,
    dailyBreakdownResponseStartTime: null,
    dailyBreakdownResponseEndTime: null,
    dailyBreakdownInputWord: null,
    dailyBreakdownOutputWord: null,
    dailyBreakdownConversations: null,
    dailyBreakdownQueryPerConversation: null,
    dailyBreakdownConversationTime: null,
    userLocation: null,
    barchartUsers: null,
    barchartSource: null,
    barchartBrowsers: null,
    barchartQueryStatus: null,
    totalQueryHourly: null,
    totalQueryDaily: null,
  }),

  actions: {
    setDateRange(newDateRange) {
      this.dateRange = newDateRange;
    },
    setcurrentSelectedDailyBreakdown(newdata) {
      this.currentSelectedDailyBreakdown = newdata;
    },
    cancelAllApiCalls() {
      source.cancel('Request canceled'); // You can provide an optional cancel message
    },
    async fetchDataFromApi(endpoint, stateProperty) {
      try {
        let queryFormat;
        if(this.dateRange == "")
          queryFormat = `?showall=true`
        else {
          const [startDate, endDate] = this.dateRange.split(" to ");
          queryFormat = `?start=${startDate}&end=${endDate}`;
        }
        const url = `/analytics/${endpoint}${queryFormat}`;
        const response = axios.get(url, {
          cancelToken: source.token, // Assign the cancel token to the request
        }).then((response) => {
          this[stateProperty] = Object.assign({}, response.data);
          console.log(this[stateProperty]);
        }).catch((err) => {
          console.error(error);
        });;
      } catch (error) {
        console.error(error);
      }
    },

    async fetchAllData() {
      const apiEndpoints = [
        { endpoint: 'total-query-count', property: 'totalQueryCount' },
        { endpoint: 'avg-response-end-time', property: 'avgResponseEndTime' },
        { endpoint: 'avg-response-start-time', property: 'avgResponseStartTime' },
        { endpoint: 'avg-query-input-word', property: 'avgQueryInputWord' },
        { endpoint: 'avg-query-output-word', property: 'avgQueryOutputWord' },

        { endpoint: 'total-conversation-count', property: 'totalConversationCount' },
        { endpoint: 'avg-query-per-conversation', property: 'avgQueryPerConversation' },
        { endpoint: 'avg-time-per-conversation', property: 'avgTimePerConversation' },

        { endpoint: 'userlocation', property: 'userLocation' },
        { endpoint: 'barchart-users', property: 'barchartUsers' },
        { endpoint: 'barchart-source', property: 'barchartSource' },
        { endpoint: 'barchart-browsers', property: 'barchartBrowsers' },
        { endpoint: 'barchart-query-status', property: 'barchartQueryStatus' },
        //{ endpoint: 'total-query-hourly', property: 'totalQueryHourly' },
        //{ endpoint: 'total-query-daily', property: 'totalQueryDaily' },
      ];
      const endPointBreakDown = [
        { endpoint: 'daily-breakdown-query', property: 'dailyBreakdownQuery' },
        { endpoint: 'daily-breakdown-response-start-time', property: 'dailyBreakdownResponseStartTime' },
        { endpoint: 'daily-breakdown-response-end-time', property: 'dailyBreakdownResponseEndTime' },
        { endpoint: 'daily-breakdown-input-word', property: 'dailyBreakdownInputWord' },
        { endpoint: 'daily-breakdown-output-word', property: 'dailyBreakdownOutputWord' },
        { endpoint: 'daily-breakdown-conversations', property: 'dailyBreakdownConversations' },
        { endpoint: 'daily-breakdown-query-per-conversation', property: 'dailyBreakdownQueryPerConversation' },
        { endpoint: 'daily-breakdown-conversation-time', property: 'dailyBreakdownConversationTime' },
      ]

      for (const { endpoint, property } of apiEndpoints) {
        this.fetchDataFromApi(endpoint, property);
      }

      this.fetchDataFromApi(endPointBreakDown[this.currentSelectedDailyBreakdown].endpoint, endPointBreakDown[this.currentSelectedDailyBreakdown].property);
    },
  }
});

// Watcher to call fetchDataOnDateRangeChange when dateRange changes


export default useGlobalStore;
