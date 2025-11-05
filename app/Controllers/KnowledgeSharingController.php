<?php
namespace App\Controllers;
class KnowledgeSharingController {
  public function index() {
    view('KnowledgeSharing/index.view.php');
  }
  public function createTopic() {
    view('KnowledgeSharing/create_topic.view.php');
  }
  public function createPost() {
    view('KnowledgeSharing/create_post.view.php');
  }
  public function createCategories() {
    view('KnowledgeSharing/create_categories.view.php');
  }
  public function viewTopic() {
    view('KnowledgeSharing/view_topic.view.php');
  }
  public function categories() {
    view('KnowledgeSharing/categories.view.php');
  }
  
}