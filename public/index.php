<?php

require_once './vendor/autoload.php';
require_once './config/eloquent.php';

// 1. Создать 5 категорий (insert)
foreach(range(1, 5) as $index) {
  $category = new \Models\Category();
  $category->title = 'Category ' . $index;
  $category->slug = 'category_' . $index;
  $category->save();
}

// 2. Изменить 1 категорию (update)
$allCategories = \Models\Category::all();

$idToEdit = $allCategories[mt_rand(0, count($allCategories) - 1)]->id;
$categoryToChange = \Models\Category::find($idToEdit);
$categoryToChange->title = 'Some new category';
$categoryToChange->save();

// 3. Удалить 1 категорию (delete).
//$idToDelete = $allCategories[mt_rand(0, count($allCategories) - 1)]->id;
//$categoryToDelete = \Models\Category::find($idToDelete);
//$categoryToDelete->posts()->delete();
//$categoryToDelete->delete();



// 4. Создать 10 постов, прикрепив случайную категорию.
for ($i = 0; $i < 10; $i++) {
  $someCategory = \Models\Category::find($allCategories[mt_rand(0, count($allCategories) - 1)]->id);
  $post = new \Models\Post();
  $post->title = 'Post ' . $i;
  $post->slug = 'post_' . $i;
  $post->body = 'some body ' . $i;
  $someCategory->posts()->save($post);
}

// 5. Обновить 1 пост, заменив поля + категорию.
$allPosts = \Models\Post::all();

$postIdToEdit = $allPosts[mt_rand(0, count($allPosts) - 1)]->id;
$postToEdit = \Models\Post::find($postIdToEdit);

$postToEdit->title = 'Post is edited';
$postToEdit->slug = 'post_edited';
$postToEdit->body = 'some edited body';
$postToEdit->category_id = $allCategories[mt_rand(0, count($allCategories) - 1)]->id;
$postToEdit->save();

// 6. Удалить пост.
$postIdToDelete = $allPosts[mt_rand(0, count($allPosts) - 1)]->id;
$postToDelete = \Models\Post::find($postIdToDelete);
$postToDelete->tags()->sync([]);
$postToDelete->delete();



// 7. Создать 10 тегов
foreach(range(1, 10) as $index) {
  $category = new \Models\Tag();
  $category->title = 'Tag ' . $index;
  $category->slug = 'tag_' . $index;
  $category->save();
}

// 8. Каждому уже сохранённому посту прикрепить по 3 случайных тега.
$allTags = \Models\Tag::all();
foreach (\Models\Post::all() as $post) {
  $someTags = [];
  for ($i = 0; $i < 3; $i++) {
    $someTagId = $allTags[mt_rand(0, count($allTags) - 1)]->id;
    array_push($someTags, $someTagId);
  }
  $post->tags()->attach($someTags);
}