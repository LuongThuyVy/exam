<?php

namespace App\Http\Controllers;
use App\Models\QuestionAnswer;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Exam;
use App\Models\SubjectGrade;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
    public function getSubjects()
    {
        $subjects = Subject::all(['id', 'name']);
        return response()->json($subjects);
    }

    public function getGrades()
    {
        $grades = Grade::all(['id', 'name']);
        return response()->json($grades);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Content' => 'required|string',
            'Difficulty' => 'required|in:Easy,Normal,Hard',
            'OptionA' => 'required|string',
            'OptionB' => 'required|string',
            'OptionC' => 'nullable|string',
            'OptionD' => 'nullable|string',
            'CorrectOption' => 'required|in:A,B,C,D',
            'SubjectId' => 'required|integer',
            'GradeId' => 'required|integer',
        ]);

        $subjectGrade = SubjectGrade::where('SubjectId', $request->SubjectId)
        ->where('GradeId', $request->GradeId)
        ->first();

    if ($subjectGrade) {
        $id = $subjectGrade->Id;
      
    }else {
        $newSubjectGrade = SubjectGrade::create([   
            'SubjectId' => $request->SubjectId,
            'GradeId' => $request->GradeId
        ]);
    $id = $newSubjectGrade->Id;
    }
        $question = new QuestionAnswer();
        $question->Content = $request->input('Content');
        $question->Difficulty = $request->input('Difficulty');
        $question->OptionA = $request->input('OptionA');
        $question->OptionB = $request->input('OptionB');
        $question->OptionC = $request->input('OptionC');
        $question->OptionD = $request->input('OptionD');
        $question->CorrectOption = $request->input('CorrectOption');
        $question->SubjectGradeId = $id;
        $question->save();
    
        return response()->json($question, 201);
    }

    public function getAllQuestions()
    {
        // Lấy tất cả các câu hỏi cùng với SubjectGrade
        $questions = QuestionAnswer::with('subject_grade')->get();
        
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($questions);
    }

    
    public function getQuestionsWithCondition(Request $request, $examId)
    {
        // Kiểm tra xem examId có được truyền vào không
        if (!$examId) {
            return response()->json(['error' => 'ExamId is required'], 400);
        }
    
        // Tìm Exam và lấy SubjectId và GradeId
        $exam = Exam::find($examId);
    
        if (!$exam) {
            return response()->json(['error' => 'Exam not found'], 404);
        }
    
        $subjectId = $exam->SubjectId;
        $gradeId = $exam->GradeId;
    
        // Lấy tất cả các câu hỏi có SubjectId và GradeId tương ứng
        $questions = QuestionAnswer::whereHas('subject_grade', function ($query) use ($subjectId, $gradeId) {
            $query->where('SubjectId', $subjectId)
                  ->where('GradeId', $gradeId);
        })->with('subject_grade')->get();
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($questions);
    }
    

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'Content' => 'required|string',
            'Difficulty' => 'required|in:Easy,Normal,Hard',
            'OptionA' => 'required|string',
            'OptionB' => 'required|string',
            'OptionC' => 'nullable|string',
            'OptionD' => 'nullable|string',
            'CorrectOption' => 'required|in:A,B,C,D',
            'SubjectId' => 'required|integer',
            'GradeId' => 'required|integer',
        ]);

        $question = QuestionAnswer::find($id);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $subjectGrade = SubjectGrade::where('SubjectId', $request->SubjectId)
            ->where('GradeId', $request->GradeId)
            ->first();

        if ($subjectGrade) {
            $subjectGradeId = $subjectGrade->Id;
        } else {
            $newSubjectGrade = SubjectGrade::create([
                'SubjectId' => $request->SubjectId,
                'GradeId' => $request->GradeId
            ]);
            $subjectGradeId = $newSubjectGrade->Id;
        }

        $question->Content = $request->input('Content');
        $question->Difficulty = $request->input('Difficulty');
        $question->OptionA = $request->input('OptionA');
        $question->OptionB = $request->input('OptionB');
        $question->OptionC = $request->input('OptionC');
        $question->OptionD = $request->input('OptionD');
        $question->CorrectOption = $request->input('CorrectOption');
        $question->SubjectGradeId = $subjectGradeId;
        $question->save();

        return response()->json($question, 200);
    }
    public function destroy($id)
    {
        // Tìm bản ghi QuestionAnswer với ID cụ thể
        $question = QuestionAnswer::find($id);
    
        // Kiểm tra nếu bản ghi không tồn tại
        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }
    
        // Xóa bản ghi
        $question->delete();
    
        // Trả về phản hồi JSON thành công
        return response()->json(['message' => 'Question deleted successfully'], 200);
    }

}    


