<template>
  <div>
    <div v-if="flag" style="width:300px">
      <div class="loading">
        <img src="/assets/images/tenor-tr.gif" />
      </div>
    </div>
    <div v-else>
      <label>IP:</label><input type="text" v-model="ip" />
      <button type="button" @click="changeServer">Change Server</button>
      <video id="video" width="280" height="500" autoplay @click="play">
        <source :src="url" type="video/mp4" />
      </video>
      <div
        style="position: absolute;
    bottom: 6px;
    font-weight: 700;
    color: #fff;
    text-shadow: 1px 1px 2px #0e0e0e;"
      >
        <p>Nickname: {{ nickname }}</p>
        <p>UniqueId: {{ uniqueId }}</p>
        <p>MusicName: {{ musicName }}</p>
        <p>AuthorName: {{ authorName }}</p>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import $ from "jquery";
export default {
  data() {
    return {
      url: "",
      data: "",
      number: 0,
      flag: true,
      ip: ""
    };
  },
  async created() {
    try {
      let el = this;
      await axios
        .get("http://facetube.anime1.opencdn.co/test.php?ip=" + this.ip)
        .then(({ data }) => {
          el.flag = false;
          el.data = data.body.itemListData;
          el.url = el.data[el.number].itemInfos.video.urls[0];
        });
    } catch (error) {
      console.log(error);
    }
    let myVideo = document.getElementById("video");

    myVideo.load();
    document.body.addEventListener("wheel", this.change);
  },
  mounted() {
    document.body.addEventListener("wheel", this.change);
  },
  computed: {
    nickname() {
      return this.data[this.number].authorInfos.nickName;
    },
    uniqueId() {
      return this.data[this.number].authorInfos.uniqueId;
    },
    musicName() {
      return this.data[this.number].musicInfos.musicName;
    },
    authorName() {
      return this.data[this.number].musicInfos.authorName;
    }
  },
  methods: {
    play() {
      let myVideo = document.getElementById("video");
      if (myVideo.paused) myVideo.play();
      else myVideo.pause();
    },
    async changeServer() {
      let el = this;
      el.flag = true;
      el.url = "";
      el.number = 0;
      await axios
        .get("http://facetube.anime1.opencdn.co/test.php?ip=" + this.ip)
        .then(({ data }) => {
          el.flag = false;
          el.data = data.body.itemListData;
          el.url = el.data[el.number].itemInfos.video.urls[0];
        });
      let myVideo = document.getElementById("video");

      myVideo.load();
    },
    change(event) {
      let el = this;
      if (event.deltaY < 0) {
        if (this.number == 0) {
          this.number = 0;

          axios
            .get("http://facetube.anime1.opencdn.co/test.php?ip=" + this.ip)
            .then(({ data }) => {
              el.data = data.body.itemListData;
              el.url = el.data[el.number].itemInfos.video.urls[0];
            });
        } else {
          this.number -= 1;
        }
        this.url = this.data[this.number].itemInfos.video.urls[0];
      } else if (event.deltaY > 0) {
        console.log(this.data.length);
        console.log(this.number);

        if (this.data.length <= this.number) {
          el.number = 0;
          axios
            .get("http://facetube.anime1.opencdn.co/test.php?ip=" + this.ip)
            .then(({ data }) => {
              el.data = data.body.itemListData;
              el.url = el.data[el.number].itemInfos.video.urls[0];
            });
        } else {
          this.number += 1;
          this.url = this.data[this.number].itemInfos.video.urls[0];
        }
      }

      let myVideo = document.getElementById("video");

      myVideo.load();
      console.log(this.url);
    }
  }
};
</script>

<style lang="scss" scoped>
* {
  margin: 0;
  padding: 0;
}
body {
  margin: 0;
  padding: 0;
}
</style>
