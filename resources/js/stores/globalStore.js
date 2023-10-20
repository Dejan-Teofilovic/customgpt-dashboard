/**
 * This module defines a Pinia store for managing global application state. It includes actions for fetching data from an API and updating various state properties. Additionally, it handles canceling ongoing API requests.
 */

// Import necessary modules
import { defineStore } from 'pinia'
import axios from '../plugins/axios'

const apiEndpoints = [
  { endpoint: 'total-query-hourly', property: 'totalQueryHourly' },
  { endpoint: 'total-query-daily', property: 'totalQueryDaily' },
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
]

const endPointBreakDown = [
  // Define the list of daily breakdown API endpoints and their corresponding state properties to update
  { endpoint: 'daily-breakdown-query', property: 'dailyBreakdownQuery' },
  { endpoint: 'daily-breakdown-response-start-time', property: 'dailyBreakdownResponseStartTime' },
  { endpoint: 'daily-breakdown-response-end-time', property: 'dailyBreakdownResponseEndTime' },
  { endpoint: 'daily-breakdown-input-word', property: 'dailyBreakdownInputWord' },
  { endpoint: 'daily-breakdown-output-word', property: 'dailyBreakdownOutputWord' },
  { endpoint: 'daily-breakdown-conversations', property: 'dailyBreakdownConversations' },
  { endpoint: 'daily-breakdown-query-per-conversation', property: 'dailyBreakdownQueryPerConversation' },
  { endpoint: 'daily-breakdown-conversation-time', property: 'dailyBreakdownConversationTime' },
]

// Create a store instance with a name 'globalStore'
const useGlobalStore = defineStore('globalStore', {
  // Define the initial state properties
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


  // Define actions to modify the state
  actions: {
    /**
     * Set the date range in the store's state.
     * @param {string} newDateRange - The new date range to set.
     */
    setDateRange(newDateRange) {
      this.dateRange = newDateRange
    },

    /**
     * Set the current selected daily breakdown in the store's state.
     * @param {number} newdata - The new selected daily breakdown.
     */
    setcurrentSelectedDailyBreakdown(newdata) {
      this.currentSelectedDailyBreakdown = newdata
    },

    /**
     * Cancel all ongoing API calls using a cancel token.
     */
    cancelAllApiCalls() {
      source.cancel('Request canceled') // You can provide an optional cancel message
    },

    /**
     * Fetch data from an API and update the specified state property with the response.
     * @param {string} endpoint - The API endpoint to fetch data from.
     * @param {string} stateProperty - The state property to update with the fetched data.
     */
    fetchDataFromApi(endpoint, stateProperty) {
      let queryFormat
      if (this.dateRange == "")
        queryFormat = `?showall=true`
      else {
        const [startDate, endDate] = this.dateRange.split(" to ")
        queryFormat = `?start=${startDate}&end=${endDate}`
      }

      const url = `/analytics/${endpoint}${queryFormat}`
      const response = axios.get(url).then(response => {
        this[stateProperty] = Object.assign({}, response.data)
        console.log(this[stateProperty])
      }, rej => {
        debugger
      }).catch(err => {
        console.error(error)
      })

    },

    /**
     * Fetch data from multiple API endpoints and update their respective state properties.
     */
    fetchAllData() {
      // Fetch data from the specified API endpoints and update state properties
      for (const { endpoint, property } of apiEndpoints) {
        this.fetchDataFromApi(endpoint, property)
      }

      // Fetch data for the selected daily breakdown endpoint and update its respective state property
      this.fetchDataFromApi(endPointBreakDown[this.currentSelectedDailyBreakdown].endpoint, endPointBreakDown[this.currentSelectedDailyBreakdown].property)
    },
  },
}
)
// Watcher to call fetchDataOnDateRangeChange when dateRange changes
export default useGlobalStore
