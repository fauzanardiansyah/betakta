<template>
    <li role="presentation" class="dropdown dropdown-notifications">
      <a
        href="javascript:;"
        class="dropdown-toggle info-number"
        data-toggle="dropdown"
        aria-expanded="true"
      >
        <i data-count="0" class="glyphicon glyphicon-bell notification-icon"></i>
        <span data-count="0" class="badge bg-green">{{ notifications.length }}</span>
      </a>
      <ul class="dropdown-menu list-unstyled msg_list" role="menu">
        <li v-for="(notification, index) in notifications" :key="index">
            <a href="#" v-on:click="markAsRead(notification)">{{ JSON.parse(notification.data).notifications.message }}</a>
        </li>
        <li v-if="notifications.length == 0">Tidak ada pemberitahuan baru</li>
      </ul>
    </li>
</template>

<script>
import Axios from 'axios';
export default {
    props: ['notifications'],
    methods: {
        markAsRead(notification) {
            var data = {
                id: notification.id
            };
            Axios.post('/notification/read', data).then(response => {
              var currentUrl = window.location.pathname;
              window.location.href = currentUrl;
            });
        }
    }
};
</script>
