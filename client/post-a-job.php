<?php
   $conn = new mysqli('localhost','root','','dnd');
   session_start();
   include('common.php');
   $id_client = $_SESSION['client_id'];

   $sql="SELECT * FROM client WHERE id_client = '$id_client'  ";
   $req = mysqli_query($conn , $sql) ;
   $num_ligne = mysqli_fetch_assoc($req) ;

   if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
   }

   if($_SERVER["REQUEST_METHOD"] == "POST") {

      $title = mysqli_real_escape_string($conn, $_POST['title']);
      $type = mysqli_real_escape_string($conn, $_POST['type']);
      $category = mysqli_real_escape_string($conn, $_POST['category']);
      $budget = mysqli_real_escape_string($conn, $_POST['budget']);
      $description = mysqli_real_escape_string($conn, $_POST['description']);
      $time = mysqli_real_escape_string($conn, $_POST['time']);

      $sql = "INSERT INTO jobs (title, type, category, budget, description, time,  id_client) VALUES ('$title', '$type', '$category', '$budget', '$description', '$time', '$id_client')";
      if(mysqli_query($conn, $sql)){
         
      } else{
         echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
      }
   }

   mysqli_close($conn);
?>
   <section>
      <div class="headline">
         <h3><i class="fas fa-regular fa-table-list"></i> Job Submission Form</h3>
      </div>

      <form action="post-a-job.php" method="POST" enctype="multipart/form-data">
         <div class="form-container">
            <div class="form-control">
               <label class="subm" for="job-title">Job Title</label>
               <input required class="ip"
                        id="job-title"
                        name="title"
                        placeholder="Enter job title...">
            </div>
            
            <div class="form-control">
               <label class="subm" for="job-type">Job Type</label>
               <select required class="sl" name="type" id="job-type">
                  <option value="">Select job type...</option>
                     <option value="Hourly project">Hourly project</option>
                     <option value="Full-Time">Full-Time</option>
                     <option value="Part-Time">Part-Time</option>
                     <option value="Fixed-Price">Fixed-Price</option>
                     <option value="Contract">Contract</option>
                     <option value="Flexible">Flexible </option>
                     <option value="Other">Other</option>
               </select>
            </div>
            
            <div class="form-control">
               <label class="subm" for="job-category">Job Category</label>
               <select required class="sl" name="category" id="job-category">
                  <option value="">Select job category...</option>
                     <option value="Web Development">Web Development</option>
                     <option value="Mobile Development">Mobile Development</option>
                     <option value="Graphic Design">Graphic Design</option>
                     <option value="Other">Other</option>
               </select>
            </div>

            <div class="form-control">
               <label class="subm" for="budget">Budget (₹)</label>
               <input required class="ip"
                        type="number"
                        id="budget"
                        name="budget"
                        min="0"
                        step="1">
            </div>

            <div class="textarea-control">
               <label class="subm" for="job-description">Job Description</label>
               <textarea required class="ta"
                        name="description"
                        id="job-description" 
                        cols="50" 
                        rows="8"
                        placeholder="Enter job description...">
               </textarea>
            </div>

            <div class="form-control">
               <label class="subm" for="job-delivery-time">Delivery Time (days)</label>
               <input required class="ip"
                     type="number"
                     id="job-delivery-time"
                     name="time"
                     min="1"
                     step="1">
            </div>
         </div>
        <center> <div class="button-cont">
        <input type="submit" class="contact-form-btn" value="Send">
        </div></center>
      </form>
   </section>