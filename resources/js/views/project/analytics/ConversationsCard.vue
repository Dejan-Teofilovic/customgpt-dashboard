<template>
  <VCard :style="{marginTop:'16px'}">
    <div :style="{padding:'24px 24px 0px 24px', fontSize:'22px'}" />
    <VCardText class="pt-6">
      <VRow>
        <VCol
          v-for="item in statistics"
          :key="item.title"
          cols="4"
          md="4"
        >
          <div
            class="queries-card gap-blocks"
            :style="{border:'1px solid #9e9e9e', borderRadius:'10px', padding:'16px', height:'100%'}"
          >
            <VAvatar
              :color="item.color"
              variant="tonal"
              size="42"
              class="me-3"
            >
              <VIcon
                size="24"
                :icon="item.icon"
              />
            </VAvatar>

            <div class="d-flex flex-column">
              <span
                class="text-h5 font-weight-medium gap-statistics"
                :style="{marginTop: '16px'}"
              >{{ item.stats }}</span>
              <span
                class="text-caption sub-information"
                :style="{fontSize:'15px !important'}"
              >
                {{ item.title }}
              </span>
            </div>
          </div>
        </VCol>
      </VRow>
    </VCardText>
  </VCard>
</template>


<script>
export default {
  data() {
    return {
      name: 'Apples',
      message: 'I like apples',
      statistics : [
        {
          title: 'Conversations',
          stats: '623',
          icon: 'custom-message-circle-2',
          color: 'primary',
        },
        {
          title: 'Queries per conversation',
          stats: '4.7',
          icon: 'custom-users',
          color: 'error',
        },
        {
          title: 'Conversation Time',
          stats: '3.2m',
          icon: 'custom-prompt',
          color: 'info',
        },
      ],
    }
  },
}
</script>



<style scoped>
  /* .custom-col {
    flex: 0 0 20% !important;
    padding: 12px !important;
    inline-size: 100% !important;
    max-inline-size: 50% !important;
  } */
</style>
