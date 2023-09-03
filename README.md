## Setup
- **Pull code, create .env file from .env_sample**
- **Run command line** ```composer install, npm install```
- **Start backend** ```php artisan serve```
- **Start frontend** ```npm run dev```
- **Migrate** ```php artisan migrate:refresh --seed```
- **Generate key** ```php artisan key:generate```

- **Generate swagger** ``php artisan l5-swagger:generate``` http://localhost:8000/api/documentation#/Register
- php artisan config:cache => xóa cache config để hàm env ko bị null
> php artisan config:clear

> compile sass: setting->tool->file watcher -> create scss-> include folder

> composer dump-autoload
> php artisan db:wipe -> xóa db nếu ko thể chạy migrate:refresh
> php artisan storage:link

> file watcher: npm install -g sass


phpstorm
select text ctr+j  ctr+al+shift => multi cursor


## Coding rules nói chung 
==========================

- Broken into proper small enough, testable functions ( Automate-testable )
- Each function has to be short (half of a screen in height, line length shouldn't be more than 80/120 chars)
Functions/Classes/Variables are named properly & meaningful. If you can't name it in English, name it in Vietnamese, that's fine too. Function names can be long if it's needed. 

- Don't make typos . Use dictionary check plugin for your IDE

- Functions are put in the right Class

- Classes should be defined suitably

- Use new empty lines when necessary in blocks of code, to make a function more readable

- Should be maintainable by the next dev. Always write code for the next maintainer. Don't write code just for urself

- Don't repeat yourself. DRY. Don't fucking repeat the code. This is extremely important. If you're writing too much code, you're doing it wrong

- Don't reinvent the wheel. Make sure you understand the **current code **base first before starting to create complicated code.

- Comments properly if needed (when the logic is too complex)

- Proper indentation

- No rubbish (extra debugging lines) when commit

- Always think of performance (example: don't findAll() & loop). Always think there are 1 billions in the system, 100K of courses....What should be run as background job, should be 
run as a job.

- Ask ask ask when you're not sure

- Writing code is almost like writing a story. Don't challenge others' brain. Make it simple!!! The more simple the better. This is the golden rule. Make it simple. If the logic is too complex, you're doing it wrong.

- Tư duy "pay the debt" aka "refactor as we go" (/images vs /xmedia/images) 
- Nguyên tắc SOLID 


Coding rules frontend
=========================
> Code cần có tâm. Code không chỉ để chạy là xong. Code phải cho the next maintainer. Code để opensource mà không bị ăn chửi -- readmin 

0. Function cần truyền đúng params nó cần, không truyền cả state vào 
```
export const getQuestionStatusInfoOfItem = (learn, tree, itemIid) => {
    const itemIidToGetInfo = itemIid || get(learn, 'itemIid');
    const trackingLine = get(learn, `info.${itemIidToGetInfo}.trackingLine`, []);
const questionsWithAnswer = get(
    learn,
    `info.${itemIidToGetInfo}.questions`,
    {},
  ); 
}  


in stead, nên lấy learnInfo từ bên ngoài và gọi bên trong ntn 
export const getQuestionStatusInfoOfItem = (learnInfo, itemIid) => {

 }

```

1. Use useRef for initializing once in a effect that has too many dependencies
  Ví dụ modules/exercise/learn/index.js
2. withConf vs withMultipleConfs
    - Để tiết kiệm request về server thì mỗi conf chỉ nên fetch 1 lần 
    - Gộp nhiều configs và dùng withMultipleConfs() để fetch 1 lần
    - Hãy tưởng tượng 10K users vào đồng thời, mỗi lần load trang mà load đến 5 requests extra. 
    - Phía PHP, kể ra request nhỏ nhất là conf/api/get không làm logic gì query db phức tạp thì cũng phải mất 9M memory. Nếu mỗi request mất 100->200 milliseconds để load ra . Nếu 10K requests đồng thời là đã mất **900 GB memory**. Cái này là impossible luôn
    - Tương tự tư duy cho các request khác không chỉ là withConf
3. When/how to give comments to function / classes. 
    - Logic nghiệp vụ cần giải thích 
    - Logic thuật toán cần giải thích 
    - Complex enough => hàm dài thì nên comment. 
    - Quy tắc: nếu hàm dài hơn 1/2 gang tay, hoặc số parameters nhiều hơn 5 tức là khả năng cao cần comment.
    - Hàm đơn giản mà bản thân tên hàm & params nhìn đã dễ hiểu thì cũng ko cần comment   
    - Cách comments 
      - Đầu hàm giải thích tổng quan hàm này làm j, đáp ứng nghiệp vụ nào 
      - Trong hàm đầu mỗi code block.
      - Nếu hàm là 1 chuỗi các event khác nhau (như exercise flow, hàm đi qua nhiều bước) thì nên thêm prefix "Step X" cho dễ hiểu 
4. Blocks of code: Cần tách các blocks of code bằng new line để nhìn cho sạch 
5. Tránh switch if else tạo ra deep level quá nhiều trong render của jsx
```
   <div>
    { bool1  ? <div>
      <Comp1>
    </div> : <div>
      <Comp2>
      {
        bool2 ? <Comp2.1> : <div> { bool3 ? <Comp3.1 /> : <Comp3.2/>
      }
    </div>
   
   </div>
```
Như ví dụ bên trên là 3 lần độ sâu. Rất khó follow. Và như trên thể hiện component của mình đang quá phức tạp. Cần
  - Check lại các booleans xem có khác đi được không 
  - Re-thinking lại interface/responsibility của component này => tách nhỏ ra nếu có thể 
6. conf: khi nào FE, khi nào BE => Luôn luôn dùng BE 
7. gv vs cloud: Nên dùng 1 config flag nào đó thay vì isGV()
8. remove class component dần dần. Khi mình làm tính năng nào đó mà va phải class component thì refactor nó trước thành functional rồi hãy đi tiếp nếu component không quá phức tạp để refactor. (Use chatgpt)
9. Configurable settings khi có thể. Ví dụ mỗi site cần hiển thị các cột khác nhau trong table. Thay vì code ra component mới thì nên làm 1 cái config cho danh sách columns đó. 
 Xem thêm  phần Cách code backward compatible 

10. Clear store (data trong localStorage, trong redux store) khi cần thiết, nhất là trong return func của useEffect(); để tránh memory leak
```
 useEffect(
    () => {
      console.log('-----------fetching course---------------');
      if (isGuest || syllabusIid !== courseIid) {
        fetchCourse(courseIid, isPreview, dispatch);
      }

      return () => {
        if (isGuest || syllabusIid !== courseIid) {
          clearFetchedCourse(courseIid, isPreview, dispatch);
        }
      };
    },
    [isGuest, learnMode, syllabusIid, courseIid, isPreview, dispatch],
  
```

11. End point api URL : 
  - Không dùng fix cứng trong code 
  - Chia theo module hợp lý ko phải mọi thứ nhét vào src/endpoints.js 
  - luôn luôn giá trị tuyệt đối :     baseUrl: 'take/api/histories',
12. Loading component & height jump: fetchData, withConf... 
  - Trong lúc đợi fetch network data (fetchData, withConf) thì cần render Loading component để tránh màn hình trắng trơn 
  - Lưu ý div height/min-height, đặc biệt trong phần main content, để tránh component bị jump height tụt lên tụt xuống khi có data/không có data/ data ít/ data nhiều 
  
13. function interface cần return 1 loại dữ liệu thống nhất 
  Ví dụ return boolean hoặc data. không nên return lẫn lộn 
14. Dùng Error code cho rõ ràng.
  - API không được trả về error message và FE dùng cái đó để display vì **BE không biết translate** (translate BE sẽ tốn performance)
  - API phải trả về errorCode (string hay integer đều acceptable, prefer integer)
  - Copy error code constants từ BE sang FE cho giống hệt nhau 

15. Bỏ extra div wrap đi. Sử dụng < />
16. lodashGet vs get() vs lGet . Dùng lodashGet thống nhất everywhere. Gặp get() thì refactor  
17. constants vs utils. Dần dần utils cơ bản sẽ biến mất trong các modules & biến thành các services độc lập. utils duy nhất là các hàm chung xử lý array/string... thì đã có sẵn và nằm trong src/common/utils rồi
Vì vậy trong các module chỉ còn là constants. Nên tách constants thành 1 file riêng và không chứa hàm nào trong này để tránh **circular dependency**, tức là import chéo loằng ngoằng giữa các file  
Ví dụ questionTypes ra 1 file riêng
Trong trường hợp pre-exam/error-alert thì constant error đang lấy từ BE và chỉ dùng trong mỗi component này để display error messages thì không cần phải tách ra file riêng, để đầu hàm cũng được  

18. images: Nếu ảnh không thay đổi thì để trong public/ để tận dụng CDN. Không nên để trong component mỗi lần build lại ra 1 đường dẫn ảnh khác nhau   
19. loop map thì phải có key : kể cả những component bên trong 
Warning: Each child in a list should have a unique "key" prop. ??? TODO: check lại chỗ này 

20. params to send to server: snake_case , đừng truyền {camelCase: 1}
21. Load heavy components thì async nếu có thể. Không nên lúc nào cũng load  
    LoadAsync (react-loadable)
    lazy (react mới)
    switch nếu cần 
```
Hiện nay trong màn Exercise dùng như sau 
  <MathJax dynamic inline>{exerciseItem}</MathJax>
   
tuy nhiên nên đổi thành 
  if (exercise.contains_math_formulas) {
    return lazy(<MathJax dynamic inline>{exerciseItem}</MathJax>) // hoặc 1 hình thức tương tự 
  } else {
    return exerciseItem
  }

để tránh lúc nào cũng load MathJax 
```
22. translations 
  - tránh dùng tên phổ biến đơn giản như 'name', dùng 'course_name' hoặc 'user_name', thậm chí là 'student_name'/'teacher_name' cho rõ ràng 
  - TODO: improve hàm t('name') thành t('name', 'user-screen') trong đó user-screen là tên page, để khi dịch có thêm context
  - Không dùng ntn: 
```   
   label: isDigiworld() ? t('public') : t1('public'), 
```  
Thay vào đó hãy để full string 'public_courses' và vào dgw.lotuslms.com/admin/translate dịch khác đi 
- ko đặt tên kiểu strings như thế này nhé
['public', 'failed'].map((menuItem) => t(`${menuItem}_courses`); vì sau này đi tìm string public_courses là sẽ ko tìm đc

23. Cách code backward compatible: Khi cầng nâng cấp API cũ, để tránh các site khác đang dùng UI mới, API cũ (như digiworld) hoặc app mobile vẫn đang dùng API cũ  
  - Có thể thêm API mới tránh break API cũ  
  - Thêm props/attribute cho entities => migrate luôn hoặc tạo prop mới & migrate on the fly
  - Dùng config bật tắt tính năng để giúp roll out tính năng dần dần cho từng site một để test cho stable hẳn   
  
24. Không cần dùng function để get value trong Function Component giống như cách viết trong class Component
```
ClassComp {
  getContent = () {
     return lodashGet(this.props, 'question.content');
  }
  
  return <Child content={this.getContent()} />;
} 

FunctionalComp = ({ question }) => {
  const content = question.content;

  return <Child content={content} />;
}
```

25. CSS cần đặt tên là styles.scss 

Không đặt style.scss hoặc stylesheet.scss 


## Folder & file structure

Typical folder structure
```
  page/
  index.js
  RouteProxy.js
  route-registration.js
  routes.js -> learnCourse(); // tất cả url frontend
  endpoints/index.js
  foo-bar/....
  FooBar.js
  services/
  store/
    schema.js
  sagas/
  reducers/
  styles.scss
```

24. RouteProxy & route-registration & routes.js
  - Không truyền { match } vào props -> getUrlParam();. Dùng RouteProxy & withRouter & lấy url param trong mapStateToProps() và truyền vào trong
  ```
     const courseId = lGet(props, 'match.params.iid');
  ```
  - Nên lấy tập trung url params ở RouteProxy, các component bên trong không cần access trực tiếp
25. page/ vs modules/: TODO 
26. Group các components theo modules. 
Ví dụ abac/ có thể trở thành common folder để chứa các thể loại liên quan đến role, perm. 
Giống như /exam là toàn bộ mọi thứ của thi , /learn là mọi phần lq đến học 1 course 
Khi có folder abac/ thì cũng nên có 1 url tương ứng với localhost:3000/abac/
27. Theme đi theo modules

```
Ví dụ course/overview/
        - theme-viki
        - default-theme 
Thay vì 
  theme-viki
      - course 
          - overview/
  default-theme 
      - course 
          - overview 
``` 
28. Services
Sử dụng cho các thao tác sau 
- synchronous Actions: data mutations, aggregate data từ các nguồn: redux store, localStorage, settings...
- Asynchronous: fetch network data có thể dùng dispatch để tách thành các service riêng
- Các dispatch services, nên truyền dispatch từ component vào. Vì trong trường hợp mình không dùng global store mà chuyển sang useReducer() hook của React (có thể vì lý do performance hoặc tính đóng gói) thì mọi thứ sẽ đỡ mất thời gian để migrate hơn 
29. Sagas & reducers 
- Cần đi theo module. Trưỡc đây mình để hết ở folder src/sagas/learn.js, giờ move về learn/sagas/index.js
30. foo-bar/index.js vs FooBar.js
- Nếu thư mục nhỏ, ví dụ dưới 6 files component thì tất cả có thể dùng FooBar.js 
- Nếu có quá 2 file css thì tách thành foo-bar/ folder . Một khi đã tách thì ko nên để cả foo-bar/index.js & FoodBart.js cùng tồn tại. nên chuyển thành folder hết 
- Nếu foo-bar map với đường dẫn kiểu như /course/123/foo-bar thì nên tách thành folder foo-bar/
31. gv/user/forgot-password hay user/forgot-password-gv  

32. Common Dumb vs Common Logic. Sẽ tách thành 2 loại common này, commonb dumb thì gióng như antd lib nhiều hơn 
33. Khi nào thì cho vào common folder?
- Không phải 1 component được dùng chung cho 2 màn (ví dụ giáo viên & học sinh) thì nhét vào components/common
Ví dụ giả thuyết 1 component là ViewTakeScore() mà cả GV & HS đều xem thì không nhét vào components/common/ViewTakeScore.js mà phải nhét vào theo logic ý nghĩa của component này làm gì.
Trong trường hợp này là nên nằm trong components/take/ViewScore.js
- manual-marking-question hiện đang để components/common là ví dụ sai cụ thể cho ví dụ trên 
- Có 3 loại folder common 
  - Common utilities toàn dự án common/ chứa các utilities. Các utilities này phần lớn ko liên quan đến React mà chỉ là javascript nói chung 
  - components/common chứa các common React components như Loading(), Button(), Helmet(), Dialog()..... Các loại common mà nghiệp vụ cụ thể như manual-marking-question thì phải để trong module /take/ hoặc /question-marking/ hoặc cái j đó tương tự. Không để trong components/common 
  - common folder trong 1 module dụ thể nào đó. Ví dụ toàn bộ thư mục src/contest giải quyết các nghiệp vụ của exam / contest (bao gồm cả tổ chức lẫn đi thi) thì có thể có thêm 1 thư mục common-components trong contest. Các common utility thì nên đưa vào services. 
  - Lưu ý nếu muốn có 1 components hay service trong 1 **module A** mà muốn các module khác sử dụng thì có 2 cách 
    - Module B mò vào tận đường dẫn trong Module A để dùng 
    - Nếu module A thực sự muốn thống nhất interface thì có thể tạo ra thư mục module-A/library/* để các modules khác import từ đây. Không chọc vào nội bộ component A. Làm ntn như trong schema-form/library. Khi mà internal của schema-form thực sự phức tạp và không muốn dev khác vô tình chọc vào
    - Khi có module-a/library/* thực chất cũng chỉ là interface mà A muốn export ra, thường nó sẽ là import các components bên trong module A để expose ra ngoài chứ ko implement gì phức tạp trong moduleA/library code 
## Component design
34. Make it functional (class Block extends Component {)
35. page & mapping với URL
36. Không để logic nằm dải rác everywhere. Ví dụ: Learn Search component các call back để ở ngoài LearnContainer sau đó truyền props xuống tận bên trong
37. Khi nào thì tạo ra 1 phiên bản mới cho PC
  - Luôn luôn prefer phiên bản auto responsive
  - Khi 2 component PC & MobileWeb trông khá khá nhau, ví dụ như <CourseHeader check quá nhiều isSmallScreen mà cách code lại không sáng sủa thì có lẽ tách ra HeaderPc & HeaderMobile cho dễ

38. khi nào thì tạo component mới cho Child hay chỉ là 1 function trong component cha
```
  render() => {
    const renderChild1 = () => {
      TopMenu 
    }
    const renderChild2 = () => {
      TopMenu 
    }
    
    title = <h1>{title}</h1>
    const child1 = renderChild1();
    const child2 = renderChild2();
    return <>{title{ {child1} {child2}</>
  }
```
trong trường hợp này tư duy child như đứa con trưởng thành. Child nên ra ở riêng (file riêng) nếu nó đủ lớn.
Dấu hiệu nhận biết con đủ lớn
- Đủ logic phức tạp (đủ thông minh)
- Ăn mặc đẹp (UI phức tạp, cần css styles riêng)

39. Clear Interface của component
  - thứ tự props cần rõ ràng 
  const Components = ({
    // 1. props mà thằng calling components cần truyền vào
    // === nên có comment phân tách ở đây
    // == store props 
    // 2. props mà component này tự sinh ra từ mapStateToProps, fetchData(), withConf()...
    // 3. Other global props như withUserInfo, withSchoolConfig
    // 4. Global props của các library như dispatch, history, ....
    }) => {
    }
  - Không nên quá nhiều props. Quá 10 props là cần xem lại thiết kế component. Có thể giải quyết bằng cách 
    - Redesign lại responsibility của comp 
    - Group props lại với nhau 
    - Dùng context
    - Cho phép component chút chít access vào store lấy dữ liệu 
  
  - Tránh gọi <Comp ...props />, nên truyền tửng props, sometimes nếu nhiều props quá thì có thể group các props lại để gọi ví dụ 
```
  const pacingProps = { pacing, serverTs, progress };
  <ChildComp 
    x={x}
    y={y}
    ...pacingProps 
  />
  thì cũng acceptable. 
  Xem thêm: https://dev.to/devsmitra/react-best-practices-and-patterns-to-reduce-code-part-2-54f3
```
  - Container vs View


## Component design 2: Passing props around & mapState & context 
40. use context to avoid passing down props too many level (> 2) (mà nhiều component ở giữa không dùng) hoặc quá nhiều context values. Mục đích là
- Tránh những components ở giữa bị pollute interface. Tự nhiên ComponentInTheMiddle trong interface lại phải carry 1 prop X chỉ để truyền xuống dưới
- Nếu component ở giữa vẫn dùng thì vẫn nên pass props thay vì dùng context.
- Việc lấy variable từ context nhiều khi cũng khó trace
- Chỉ nên dùng context ở 1 số component container bên ngoài

41. mapStateToProps chỉ nên map thông thường lấy data thô, không nên xử lý logic gì phức tạp ở đây.  (Tư duy như repository backend's repository pattern)
- Ví dụ: src/modules/exercise/learn/NormalExercise/index.js
- Repository pattern: https://www.dotnetcurry.com/aspnet-mvc/1155/aspnet-mvc-repository-pattern-perform-database-operations
- Khi các data được sinh ra nhiều quá trong mapStateToProps sẽ dẫn đến
  - Interface của component lại phải declare những props phái sinh này làm pollute interface của component
  - Bản chất những props này là data sinh ra được đầu component
  - Có thể làm component bị re-render mà mình không biết
- Các data phái sinh là các data dành cho business logic hoặc cho view rendering thì làm ở đầu functional component. Không làm trong mapState
- Nếu data phái sinh generate phức tạp quá cho thể để thành function riêng, để trong services/
- Tách thành hàm riêng nếu dùng nhiều. Tránh lodashGet(state, 'learn.info') everywhere . Các hàm này đặt trong services/ cũng được kể cả hàm ví dụ như getCourseObject về pattern thì chỉ là nằm trong repository thôi

42. Tư duy thiết kế: Truyền props xuống hay component nào cũng đi lấy từ state ????? TODO
43. Bỏ mapDispatchToProps: thay vào đó biến thành các service ở đầu component, giống như mapStateToProps bên trên
44. Không đặt tên trùng giữa prop truyền xuống & prop lấy từ map State to props
```
Parent.js 
  return  <Child x = 1 > 
Child.js 
 const mapStateToProps = (state, props) => {
   if (!props.x) {
    x = state.x;
   }
   return {
    x, // lúc này x có thể bằng 2 
   }
}
``` 
Khi design ntn là về mặt design component chúng ta có vấn đề, cần refactor lại

45. Group theo logic ko phải group theo input
```
NormalExercise.js 
let shouldShowReviewBtn;
let shouldShowFinishBtn;

if (options.sequence) {
  shouldShowFinishBtn = ..
  shouldShowReviewBtn = ..
}  
if (isComplexExercise) {
  shouldShowFinishBtn = ..
  shouldShowReviewBtn = ...
}
----------
Lẽ ra phải group 
  shouldShowFinishBtn = () => {}
  shouldShowReviewBtn = () => {}
```


## Naming things
> There are only two hard things in Computer Science: cache invalidation and naming things. -- Phil Karlton

- Naming áp dùng cho class, function, variables.... Các ví dụ đặt tên không rõ ràng

```
showOutOverviewCourse, CourseAsBanner, always_lock_item_if_it_is_locked

const ContentByTab = ({});

var data = (); // trong 1 số trường hợp biến ntn vẫn make sense, nhưng đa số là tên kiểu chung chung data là vô nghĩa 

const Index = ({ course }) => { // Do dùng IDE 

const BarChartOverView = ({ data, groupText }) => {
tên BarChartOverView quá chung chung. 
```
- English vs VNese: Có thể đặt tên VN nhưng ko recommended. Dùng Google Translate, học thêm basic English 
- Đặt tên theo tác dụng business của nó. Nên đặt tên là "Cái bảng" thay vì "hình chữ nhật", kể cả trong trường hợp use case là mình chỉ dùng để mô tả hình dáng cái bảng là hình chữ nhật, chưa nói gì đến công năng viết phấn của bảng, nhưng bối cảnh nó là lớp học thì vẫn nên đặt tên nó là cái bảng. 
- Lưu ý khi refactor component / hàm bị auto renamed cần check lại 


## Fetch/post data 
- fetch: dataApiResults, fetchData, fetchNode, ...
- post: SimpleSubmitForm, submitFormRequest
- Trong schema-form : search -> state.searchResults
- Trong schema-form element: 
- SImple post/get: Requester.post(url, params).then((response) => { if (response.success {}});

- See everything in & dùng Store.dispatch để init 
- fetchNodesRequest / updateNodeRequest / deleteNodeRequest:  trong actions/node/saga-creators;
- fetchNode() trong src/actions/node/creators.js; 
- nodeSagaActions.getDataRequest() sẽ store dữ liệu vào state.dataApiResults[$keyState] (keyState là conf riêng cho mỗi request)

TODO: Không hiểu tại sao mấy thằng nằm trong actions/node/saga-creators còn fetchNode lại nằm trong  actions/node/creators.js.
- fetchData Hoc 
  - Re-renders
  - Nested Tree
- SimpleSubmitForm 
- Sometime re-fetch node cần tách thành service riêng khi có nhiều chỗ cần fetch/refech data. Ví dụ trong màn edit contest, rất nhiều action bên trong sau khi thực hiện thì cần refresh lại object contest thì hàm __refetchContest(contestIid)__ đã được viết thành service để các component bên trong gọi cho tiện   

- react-query: Nghiên cứu dùng lib này thay cho fetchData 


## Schema form 
- extraProps là gì 
- use schema-form/lib/Text.js... đừng dùng { type: 'text' } 
- Sử dụng displayElement trong trong freestyle layout
```
  import { displayElement } from 'schema-form/FormLayout';
```
- Khi layout dàn hàng ngang trong free style layout form, để search button thẳng hàng, dùng class 'element-default'
```
   <div className="col-md-4 element-default">{submitButton}</div>
```
## Debugging
- withPropsChange() HOC to monitor props changing in real time
- useEffectDebugger() to monitor dependencies changing in real time
- logState('state.learn');
- watchState('state.learn'); to watch redux state changing in real time
- Component inspector
- console.log()
- debugger
- localStorage.debugTranslation = 1;
- React Profiler (https://react.dev/reference/react/Profiler) or  React Developer Tools's Profiler. They're the same

##CSS
BEM ?

```
<div className='d-flex'>
<div className='d-flex align-items-center'> (vertical)
<div className='d-flex justify-content-center'> (horizontal)
```

## /learn logic 

Refer tới **components/learn/Readme.md**

## exercise logic 
Refer tới **modules/exercise/Readme.md**

## Contest
Refer tới **components/contest/Readme.md**

## Syllabus editor 
TODO: 

## Buttons
- components/common/button/ButtonPrimary.js
- components/common/button/ButtonSecondary.js
- components/common/button/ButtonNormal.js

## Loading
import Loading from 'components/common/loading';
