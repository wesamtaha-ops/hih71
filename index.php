<!DOCTYPE html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>نموذج استطلاعي جديد</title>
    <!-- Link to Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Almarai:wght@400;700&display=swap" rel="stylesheet">
    <!-- Link to Bootstrap CSS stylesheet -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
      body {
        font-family: 'Almarai', sans-serif;
        background-color: #e9ecef;
                text-align: right;

      }
      #poll-form {
        background-color: #fff;
        border-radius: 20px;
        padding: 20px;
      }
      label, input, select, textarea {
        text-align: right;
      }
    </style>
  </head>
  <body>
    <div class="container">
        
   
    
      <div class="row justify-content-center">
          
            <div class="col-lg-6">
          <h1 class="mt-5 mb-3 text-center">  Ai Generateor </h1>
          <form id="poll-form">
              <select class="form-control" id="my-select" style="margin-bottom: 10px">
                <option selected value="1">العالم</option><option value="2">الكويت</option><option value="3">مصر</option><option value="4">السعودية</option><option value="5">الإمارات</option><option value="6">لبنان</option><option value="7">البحرين</option><option value="10">الأردن</option><option value="11">فلسطين</option><option value="12">اليمن</option><option value="13">المغرب</option><option value="14">ليبيا</option><option value="15">تونس</option><option value="17">تكنولوجيا</option><option value="18">رياضة</option><option value="19">صحة</option><option value="22">عمان</option><option value="23">سيارات</option><option value="26">العراق</option><option value="27">إقتصاد</option><option value="33">الجزائر</option><option value="34">عالم</option><option value="حواء">undefined</option><option value="37">منوعات</option><option value="39">موريتانيا</option><option value="40">قطر</option><option value="41">قضايا</option></select>


              
            <div class="form-group">
             <button type="button" class="btn btn-primary" id="get-news-btn">احصل على خبر عشوائي</button>




    <br /><br />
    <h5 id="h3"></h5><br />
              <textarea rows="5" id="gpt-question" name="gpt-question" class="form-control" required></textarea>
            </div>
            <div class="form-group">
              <img src="" width="200" id="image-url" />
            </div>
            
            <!--<div class="form-group">-->
            <!--      <button class="btn btn-primary" type="button" onclick="openChat()"> تسخ والذهاب ل CHATGPT </button>-->
            <!--</div>-->
            
            <div class="form-group">
                  <button class="btn btn-warning" id="generate" type="button" onclick="connectToGPT()"  >  توليد السؤال بالذكاء الصناعي </button>
            </div>
            <div class="form-group">
                <textarea placeholder="مسودة يمكنك لصق الجواب" id="gpt-answer" rows="10" name="gpt-answer" class="form-control" ></textarea>
            </div>
          </form>
        </div>
        
        <div class="col-lg-6">
          <h1 class="mt-5 mb-3 text-center">إنشاء استطلاع جديد</h1>
          <form id="poll-form">
           
            <div class="form-group">
              <label for="image">رابط الصورة:</label>
              <input type="url" id="image" name="image" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="category">الفئة:</label>
              <select id="category" name="category" class="form-control">
                <option value="food">الطعام</option>
                <option value="sports">الرياضة</option>
                <option value="movies">الأفلام</option>
                <option value="music">الموسيقى</option>
              </select>
            </div>
            
             <div class="form-group">
              <label for="question">السؤال:</label>
              <textarea id="question" name="question" class="form-control" required></textarea>
            </div>
            
            <div class="form-group">
              <label for="option1">الخيار 1:</label>
              <input type="text" id="option1" name="option1" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="option2">الخيار 2:</label>
              <input type="text" id="option2" name="option2" class="form-control" required>
            </div>
            <div class="form-group">
              <label for="option3">الخيار 3:</label>
              <input type="text" id="option3" name="option3" class="form-control">
            </div>
            <div class="form-group">
              <label for="option4">الخيار 4:</label>
              <input type="text" id="option4" name="option4" class="form-control">
            </div>
            <button type="submit" disabled class="btn btn-primary">نشر الاستطلاع</button>
          </form>
        </div>
      </div>
    </div>
    <!-- Link to jQuery and Bootstrap JS scripts -->

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    
    
    <script>
        

const connectToGPT = async function() {
    const API_KEY = "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"; // Replace with your own API key
    const API_URL = "https://api.openai.com/v1/completions";
        document.getElementById('question').value = "";
        document.getElementById('image').value = "";
        document.getElementById('option1').value = "";
        document.getElementById('option1').value = "";
        document.getElementById('option2').value = "";
        document.getElementById('option3').value = "";
        document.getElementById('option4').value = "";
        document.getElementById('generate').value = '...';
        document.getElementById('generate').innerHTML = '<div class="spinner-border text-light" role="status"> <span class="sr-only">Loading...</span> </div>'
'<div class="spinner-border text-light" role="status"> <span class="sr-only">Loading...</span> </div>';
    
    
var Question = "convert this news to poll in Arabic with 4 short voting options listed as 1. 2. 3. 4.: "; //"حول هذا الخبر لسؤال تصويت مع أربع خيارات بسيطة A. B. C. D.  لا تتجاوز ٤ كلمات: ";

      const response = await fetch(API_URL, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          "Authorization": `Bearer ${API_KEY}`,
        },
        body: JSON.stringify({
              "model": "text-davinci-003",
              "prompt":  Question + " \n " +  document.getElementById('gpt-question').value.split(/\.\n/)[0],
              "temperature": 0.7,
              "max_tokens": 2184,
              "top_p": 1,
              "frequency_penalty": 0.7,
              "presence_penalty": 0,
              "stop": ["You:"]
        })
      });
    
      const data = await response.json();
      document.getElementById('gpt-answer').value = data.choices[0].text;
      document.getElementById('generate').value = ' توليد السؤال بالذكاء الصناعي';
      document.getElementById('generate').innerHTML = ' توليد السؤال بالذكاء الصناعي';
      
        const str = data.choices[0].text;

        
        
        const question = str.split('1. ')[0];
        document.getElementById('question').value = question.replace(/\n/g, ""); 

            
        const answerChoices = str.split(/1\.|2\.|3\.|4\./);
        const choiceA = answerChoices[answerChoices.length - 4];
        const choiceB = answerChoices[answerChoices.length - 3];
        const choiceC = answerChoices[answerChoices.length - 2];
        const choiceD = answerChoices[answerChoices.length - 1];
                
                
        document.getElementById('option1').value = choiceA;
        document.getElementById('option2').value = choiceB;
        document.getElementById('option3').value = choiceC;
        document.getElementById('option4').value = choiceD;
        
                
        console.log(question);


        console.log(choiceA);
        console.log(choiceB); 
        console.log(choiceC);
        console.log(choiceD); 
        
      
      
}



document.addEventListener("DOMContentLoaded", function() {

  const getNewsBtn = document.getElementById("get-news-btn");
  const newsArticle = document.getElementById("news-article");
  

  getNewsBtn.addEventListener("click", function() {

    const url = "https://api1.akhbarna.today/api/v1/section/votly/latest/" + document.querySelector("#my-select").value;
    
    // Make a GET request to the API
    fetch(url)
      .then(response => response.json())
      .then(data => {
        // Get a random news article from the API response
        const articles = data.data;
        const randomIndex = Math.floor(Math.random() * articles.length);
        const randomArticle = articles[randomIndex];
        // Display the random news article in the HTML page 

        var news = document.getElementById('question').value;
        var GPTQuestion =  randomArticle.breif ? randomArticle.breif.replace(/<[^>]+>/g, "").split(/\.\n/)[0] : randomArticle.title ;
        document.getElementById('gpt-question').value = GPTQuestion;
        document.getElementById('image-url').src = randomArticle.imageUrl;
        document.getElementById('image').value = randomArticle.imageUrl;
        
        document.getElementById('h3').innerHTML = randomArticle.title;
        document.getElementById('question').value = "";
        document.getElementById('image').value = "";
        document.getElementById('option1').value = "";
        document.getElementById('option1').value = "";
        document.getElementById('option2').value = "";
        document.getElementById('option3').value = "";
        document.getElementById('option4').value = "";
        
        
      })
      .catch(error => {
        console.error("Error fetching news: ", error);
        newsArticle.textContent = "حدث خطأ في جلب الأخبار. يرجى المحاولة مرة أخرى في وقت لاحق.";
      });
  });
});




    </script>


<style>
    .form-control {
    line-height: 2;
    height: 50px;
}
</style>