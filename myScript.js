var max = 1000
var min = 100
var timer = null
var pplArr = null
var peopleID = 0
class Family {
  constructor(id, memberCount, food){
    this.id = id,
    this.food = food
  }

  get members(){
    if(this.memberlist == null){
      this.memberlist = new Array()
    }
    return this.memberlist
  }
}
class People {
  constructor(id, good, age, work, strong){
    this.id = id,
    this.good = good,
    this.age = age,
    this.work = work,
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
        this.pplArr = this.createFamilyArray()
      }
      this.showCountLogs()
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
    },
    familyArr(){
      return new Array()
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
    createYoungPeople(){
      return this.createPeople('young')
    },
    createOldPeople(){
      return this.createPeople('old')
    },
    createChildPeople(){
      return this.createPeople('child')
    },
    createPeople(type){
      var goodMax, goodMin
      var ageMax, ageMin
      var workMax, workMin
      if(type == 'young'){
        goodMax = 99, goodMin = 60
        ageMax = 60, ageMin = 20
        workMax = 100, workMin = 90
      }else if(type == 'old'){
        goodMax = 80, goodMin = 30
        ageMax = 100, ageMin = 61
        workMax = 0, workMin = 0
      }else if(type == 'child'){
        goodMax = 99, goodMin = 60
        ageMax = 0, ageMin = 19
        workMax = 0, workMin = 0
      }
      var good = Math.floor(Math.random() * (goodMax - goodMin) + goodMin)
      var age = Math.floor(Math.random() * (ageMax - ageMin) + ageMin)
      var workInt = Math.floor(Math.random() * (workMax - workMin) + workMin)
      var work
      if(workInt>60){
        work = true
      }else{
        work = false
      }
      var strong
      if (age<20){
        strong = Math.floor((Math.random() * (99 - 80) + 80)/20*age)
      }else if (age>=60){
        strong = Math.floor((Math.random() * (99 - 80) + 80)/100*(100-age+60))
      }else{
        strong = Math.floor((Math.random() * (99 - 80) + 80))
      }
      var ppl = new People(this.peopleID,good,age,work,strong)
      this.peopleID +=1
      return ppl
    },
    createFamilyArray(){
      var arr = new Array()
      var totalCount = this.myCopy(this.peopleCount)
      console.log('totalCount: '+totalCount)
      while(totalCount>0){
        var familyMemberMax = Math.floor(Math.random() * (10 - 1) + 1)//rand for young old
        var count = Math.floor(Math.random() * (familyMemberMax - 1) + 1)//family members count
        if(count > totalCount){
          count = totalCount
        }
        var foodR = Math.floor(Math.random() * (100 - 40) + 40)//rand for young old
        var familyID = this.familyArr.count
        var family = new Family(familyID, foodR)
        for(var i=0; i<count; i++){
          var rand = Math.floor(Math.random() * (10 - 0) + 0)//rand for young old
          var ppl
          if(rand<5){
            ppl = this.createYoungPeople()
          }else if(rand<7){
            ppl = this.createOldPeople()
          }else{
            ppl = this.createChildPeople()
          }
          // console.log('ppl: '+ppl)
          if(ppl){
            arr.push(ppl)
            family.members.push(ppl)
          }
        }
        this.familyArr.push(family)
        // console.log(family.memberlist)
        totalCount -= count
        // console.log('count: '+count)
        // console.log('totalCount: '+totalCount)
      }
      return arr
    },
    showCountLogs(){
      var youngCount=0, oldCount=0, childCount=0
      for(var i=0; i<this.pplArr.length; i++){
        var age = this.pplArr[i].age
        if(age>=20 && age<60){
          youngCount++
        }else if(age<20){
          childCount++
        }else{
          oldCount++
        }
      }
      console.log('count result: '+childCount+' '+youngCount+' '+oldCount)
      console.log('family count result: '+this.familyArr.length)
    }
  }
})