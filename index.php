<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <title>病毒來襲</title>

  <!-- production version, optimized for size and speed -->
  <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
  
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

  <!-- Optional theme -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

  <!-- Latest compiled and minified JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  <style>
    @font-face {
      font-family: myFont;
      src: url(SentyWEN2017.ttf);
    }

    body {
      font-family: myFont;
    }

    html, body, .container-table {
        height: 100%;
    }

    .container-table {
        display: table;
    }
    .vertical-center-row {
        display: table-cell;
        vertical-align: middle;
    }
    .bottom-space {
      padding-bottom: 30px;
    }
  </style>
</head>
<body>
  <div id="app" class="container container-table">
    <div class="row vertical-center-row">
        <div class="jumbotron text-center">
          <div class="row bottom-space">
            <h1>病毒來襲</h1>
            <small>管理您的國家，嘗試把疫情控制住！</small>
          </div>
          <div v-if="started">
            <div class="bottom-space">
              <p>第 {{ day }} 天</p>
              <p>總人口：{{ peopleCount }}</p>
              <p>總確診人數：{{ confirmedCount }}</p>
              <p>今日確診人數：{{ todayConfirmCount }}</p>
              <p>死亡人數：{{ deadCount }}</p>
              <p>人民滿意度：{{ happy }}%</p>
              <p>經濟情況：{{ money }}%</p>
              <p>警戒級別：{{ alertLevel }}</p>
            </div>
            <div>
              <button type="button" class="btn btn-info" v-on:click="downBtnClicked()">降級警戒</button>
              <button type="button" class="btn btn-danger" v-on:click="upBtnClicked()">升級警戒</button>
              <button type="button" class="btn btn-success" v-on:click="nextBtnClicked()">{{ nextBtnStr }}</button>
            </div>
          </div>
          <div v-else="started" class="row">
            <button type="button" class="btn btn-success" v-on:click="startBtnClicked()">開始</button>
          </div>
        </div>  
    </div>
  </div>

  

  <script>
    var max = 100
    var min = 10
    var timer = null
    var pplArr = null
    var app = new Vue({
      el: '#app',
      data: {
        timeLimit: 10,
        timePassed: 0,
        started: false,
        loading:false,
        day: 1,
        peopleCount: Math.floor(Math.random() * (max - min) + min),
        confirmedCount: 0,
        todayConfirmCount: 0,
        deadCount: 0,
        happy: 100,
        money: 100,
        alertLevel: 0
      },
      computed: {
        timeLeft() {
          return this.timeLimit - this.timePassed
        },
        nextBtnStr() {
          if(this.loading){
            return '下一天 ('+ this.timeLeft +')s'
          }else{
            return '下一天'
          }
        },
        getPeopleArray() {
          if(this.pplArr == null){
            var arr = new Array()
            for(var i=0; i<this.peopleCount; i++){
              var ppl = {id:i, good:true}
              arr.push(ppl)
            }
            this.pplArr = arr
          }
          return this.pplArr
        }
      },
      methods: {
        startBtnClicked(){
          this.started = true
          console.log(this.getPeopleArray[this.peopleCount-1])
        },
        nextBtnClicked(){
          console.log(this.loading)
          if(this.loading == false){
            this.day += 1
            this.startCount()
          }
        },
        downBtnClicked(){
          if(this.alertLevel > 0 && this.loading == false){
            this.alertLevel -= 1
          }
        },
        upBtnClicked(){
          if(this.alertLevel < 5 && this.loading == false){
            this.alertLevel += 1
          }
        },
        startCount(){
          this.loading = true
          this.timer = setInterval(this.countDown, 1000)
        },
        endCount(){
          this.loading = false
          clearInterval(this.timer)
        },
        countDown(){
          if(this.timeLeft>0){
            console.log(this.timePassed)
            this.timePassed += 1
          }else{
            this.endCount()
            this.timePassed = 0
          }
        }
      }
    })
  </script>
</body>
</html>