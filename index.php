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
    class People {
      constructor(id, good, age, work, food, strong){
        this.id = id,
        this.good = good,
        this.age = age,
        this.work = work,
        this.food = food,
        this.strong = strong
      }
    }
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
        alertLevel: 0,
        cityCount: 3,
        cityArr: null
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
            var totalCount = this.myCopy(this.peopleCount)
            var youngCount = Math.floor(totalCount/2)
            totalCount -= youngCount
            var oldCount = Math.floor(totalCount/3*2)
            totalCount -= oldCount
            var childCount = totalCount
            this.insertPeople(arr, youngCount, 'young')
            this.insertPeople(arr, oldCount, 'old')
            this.insertPeople(arr, childCount, 'child')
            this.pplArr = arr
          }
          return this.pplArr
        },
        getCityArray(){
          if(this.cityArr == null){
            var nameArr = ["A", "B", "C"]
            var arr = []
            var totalCount = this.peopleCount.copy
            for(var i=0; i<this.cityCount; i++){
              var mother = Math.floor(Math.random() * (5 - 1) + 1)
              var pplCount
              if(i == this.cityCount-1){
                pplCount = totalCount
              }else{
                pplCount = totalCount/mother
                totalCount -= pplCount
              }
              var city = new City(nameArr[i],pplCount)
              arr.push(city)
            }
            this.cityArr = arr
          }
          return this.cityArr
        }
      },
      methods: {
        startBtnClicked(){
          this.started = true
          console.log(this.getPeopleArray)
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
        },
        myCopy(obj){
          return JSON.parse(JSON.stringify(obj));
        },
        insertPeople(arr, count, type){
          var goodMax, goodMin
          var ageMax, ageMin
          var workMax, workMin
          var foodMax, foodMin
          if(type == 'young'){
            goodMax = 99, goodMin = 60
            ageMax = 60, ageMin = 20
            workMax = 100, workMin = 90
            foodMax = 100, foodMin = 40
          }else if(type == 'old'){
            goodMax = 80, goodMin = 30
            ageMax = 100, ageMin = 61
            workMax = 0, workMin = 0
            foodMax = 100, foodMin = 40
          }else if(type == 'child'){
            goodMax = 99, goodMin = 60
            ageMax = 0, ageMin = 19
            workMax = 0, workMin = 0
            foodMax = 100, foodMin = 40
          }
          for(var i=0; i<count; i++){
              var good = Math.floor(Math.random() * (goodMax - goodMin) + goodMin)
              var age = Math.floor(Math.random() * (ageMax - ageMin) + ageMin)
              var workInt = Math.floor(Math.random() * (workMax - workMin) + workMin)
              var work
              if(workInt>60){
                work = true
              }else{
                work = false
              }
              var food = Math.floor(Math.random() * (foodMax - foodMin) + foodMin)
              var strong
              if (age<20){
                strong = Math.floor((Math.random() * (99 - 80) + 80)/20*age)
              }else if (age>=60){
                strong = Math.floor((Math.random() * (99 - 80) + 80)/100*(100-age+60))
              }else{
                strong = Math.floor((Math.random() * (99 - 80) + 80))
              }
              var ppl = new People(i,good,age,work,food,strong)
              arr.push(ppl)
            }
        },
      }
    })
  </script>
</body>
</html>