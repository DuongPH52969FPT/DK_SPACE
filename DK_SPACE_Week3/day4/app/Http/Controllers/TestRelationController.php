<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestRelationController extends Controller
{
    public function index()
    {

        //         Mục tiêu
        // Ví dụ sử dụng
        // Tạo mới 1 khóa học, kèm theo 3 bài học
        // Sử dụng Eloquent và quan hệ 1-n
        // Gắn tag 'Laravel' và 'Eloquent' cho 1 bài học
        // Sử dụng attach() và sync()
        // Lấy tất cả comment của một course bất kỳ
        // Sử dụng quan hệ morphMany()
        // Hiển thị danh sách khóa học + tổng số bài học & comment
        // withCount() kết hợp morph count nếu cần
        // Tìm lesson có tag 'Performance' và nhiều hơn 3 comment
        // Sử dụng whereHas + withCount + morph query


        // 1. Tạo mới 1 khóa học, kèm theo 3 bài học
        $user = User::first();
        if (!$user) {
            return 'No user found. Please create a user first.';
        }
        $course = $user->courses()->create([
            'title' => 'Khóa học Laravel',
            'description' => 'Học Laravel từ cơ bản đến nâng cao'
        ]);
        $lessons = $course->lessons()->createMany([
            ['title' => 'Bài 1', 'content' => 'Nội dung 1'],
            ['title' => 'Bài 2', 'content' => 'Nội dung 2'],
            ['title' => 'Bài 3', 'content' => 'Nội dung 3'],
        ]);

        // 2. Gắn tag 'Laravel' và 'Eloquent' cho 1 bài học
        $tagLaravel = Tag::firstOrCreate(['name' => 'Laravel']);
        $tagEloquent = Tag::firstOrCreate(['name' => 'Eloquent']);
        $lessons[0]->tags()->sync([$tagLaravel->id, $tagEloquent->id]);


        $comments = $course->comments;

        // 4. Hiển thị danh sách khóa học + tổng số bài học & comment
        $courses = Course::withCount('lessons')
            ->withCount(['comments as comments_count'])
            ->get();

        // 5. Tìm lesson có tag 'Performance' và nhiều hơn 3 comment
        $tagPerformance = Tag::firstOrCreate(['name' => 'Performance']);
        $lessonWithPerformance = Lesson::whereHas('tags', function ($q) use ($tagPerformance) {
            $q->where('tags.id', $tagPerformance->id);
        })
            ->withCount('comments')
            ->having('comments_count', '>', 3)
            ->get();



        return compact(
            'course',
            'lessons',
            'comments',
            'courses',
            'lessonWithPerformance'
        );
    }
}
