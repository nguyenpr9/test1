# Detail Design v2

> Lưu ý: Flow/chart/hyperlink điều hướng trực quan nằm trong file .xlsx; markdown chỉ thể hiện bảng text.

## Sheet: 00_ReadMe_Visual

|  | DETAIL DESIGN V2 - VISUAL NAVIGATION |  |  |  |  |  |
| --- | --- | --- | --- | --- | --- | --- |
|  | Đọc nhanh theo thứ tự:<br>1) ERD_Star_Visual_v2<br>2) ETL_Swimlane_v2<br>3) Traceability_Matrix_v2<br>4) RLS_Heatmap_v2<br>5) Refresh_Monitor_v2 |  |  | Ý nghĩa màu:<br>Xanh đậm: thành phần lõi<br>Xanh lá: vận hành ổn định<br>Cam/Đỏ: rủi ro/cảnh báo<br>Xám: chi tiết dữ liệu<br><br>Bản v2 nhằm giảm độ nặng chữ, tăng khả năng review liên phòng ban. |  |  |
|  | TIP: Stakeholder có thể review flow + chart trước, sau đó mới xuống các sheet DataModel/SourceMapping/DAX để xác nhận khả thi triển khai. |  |  |  |  |  |
|  | Quick Links - Bắt đầu đọc từ đây |  |  |  |  |  |
|  | Step | Sheet | Mục tiêu |  |  |  |
|  | 1 | 00_ReadMe_Visual | Nắm roadmap đọc tài liệu detail |  |  |  |
|  | 2 | ERD_Star_Visual_v2 | Hiểu cấu trúc star schema trực quan |  |  |  |
|  | 3 | ETL_Swimlane_v2 | Hiểu trình tự ETL và các gate kiểm soát |  |  |  |
|  | 4 | Overview | Hiểu SLA, tầng dữ liệu, giả định triển khai |  |  |  |
|  | 5 | Modules | Hiểu phạm vi từng subject area |  |  |  |
|  | 6 | DashboardCatalog | Hiểu mục tiêu từng dashboard |  |  |  |
|  | 7 | DashboardLayoutSpec | Hiểu vị trí visual + field binding |  |  |  |
|  | 8 | KPI | Hiểu business definition + ngưỡng KPI |  |  |  |
|  | NEW IN v2.2 - Module detail path |  |  |  |  |  |
|  | Bước mới cần đọc sau Modules: | Module_Function_Spec_v2 | Mô tả chi tiết từng module cần làm gì ở mức implement |  |  |  |

## Sheet: 01_Reading_Path_v2

| DETAIL DESIGN - RECOMMENDED READING PATH (UPDATED WITH MODULE FUNCTION SPEC) |  |  |  |  |  |  |
| --- | --- | --- | --- | --- | --- | --- |
| Đọc theo thứ tự. Cột "Liên kết sheet" có hyperlink. Bổ sung bước Module_Function_Spec_v2 để dev biết rõ từng module cần làm gì. |  |  |  |  |  |  |
| Step | Liên kết sheet | Mục tiêu đọc | Input nhận từ | Output chuyển tới | Persona chính | Kết quả kỳ vọng |
| 1 | 00_ReadMe_Visual | Nắm roadmap đọc tài liệu detail | - | ERD_Star_Visual_v2 | All | Biết điểm bắt đầu |
| 2 | ERD_Star_Visual_v2 | Hiểu cấu trúc star schema trực quan | ReadMe | ETL_Swimlane_v2 | Data + BI Dev | Nắm liên kết Fact/Dim |
| 3 | ETL_Swimlane_v2 | Hiểu trình tự ETL và gate kiểm soát | ERD | Overview | Data Engineer | Chốt luồng pipeline |
| 4 | Overview | Hiểu SLA, tầng dữ liệu, giả định triển khai | ETL Flow | Modules | Architect + PM | Đồng thuận kiến trúc |
| 5 | Modules | Hiểu phạm vi module và mục tiêu nghiệp vụ | Overview | Module_Function_Spec_v2 | Business + PMO | Chốt scope theo module |
| 6 | Module_Function_Spec_v2 | Hiểu chi tiết từng module cần làm gì ở mức chức năng | Modules | DashboardCatalog | Dev Lead + BA | Lập backlog implement rõ ràng |
| 7 | DashboardCatalog | Hiểu mục tiêu từng dashboard | Module function spec | DashboardLayoutSpec | Report Designer | Chốt trang báo cáo |
| 8 | DashboardLayoutSpec | Hiểu vị trí visual + field binding | DashboardCatalog | KPI | Power BI Dev | Triển khai UI/UX report |
| 9 | KPI | Hiểu business definition + ngưỡng KPI | Dashboard spec | Traceability_Matrix_v2 | Business + QA | Chốt tiêu chí nghiệm thu |
| 10 | Traceability_Matrix_v2 | Trace KPI -> DAX -> Source -> Test | KPI | DataModel | Dev + QA | Không thiếu mapping |
| 11 | DataModel | Chi tiết field-level cho Fact/Dim | Traceability | ModelRelationships | Data Modeler | Build model chính xác |
| 12 | ModelRelationships | Hiểu cardinality/filter direction | DataModel | SourceMapping | Power BI Dev | Tránh filter ambiguity |
| 13 | SourceMapping | Map source -> semantic + transform | Model | DAXLogic | ETL Dev | Triển khai ETL chuẩn |
| 14 | DAXLogic | Công thức DAX đầy đủ + test case | KPI + Mapping | BusinessRules | Power BI Dev | Measure chạy đúng logic |
| 15 | BusinessRules | Luật nghiệp vụ và ngoại lệ | DAX | RLS_Heatmap_v2 | Business + QA | Bộ rule kiểm thử hoàn chỉnh |
| 16 | RLS_Heatmap_v2 | Nhìn nhanh phạm vi role và access | BusinessRules | RLS | Security | Xác nhận policy trước publish |
| 17 | RLS | DAX filter role-level trong service | RLS heatmap | Refresh_Monitor_v2 | Security + Admin | Thiết lập phân quyền chính thức |
| 18 | Refresh_Monitor_v2 | Theo dõi vận hành refresh/DQ sau triển khai | All implementation | Runbook | Operations | Sẵn sàng go-live monitoring |

## Sheet: ERD_Star_Visual_v2

|  | STAR SCHEMA VISUAL (Detailed Semantic Layer) |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
|  | DimProject |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |
|  |  |  |  |  |  | → |  |  |  |  |  |  |  |  |  |  |  |  |  |  | DimDate |  |  |  |  |
|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  | → |  |  |  |  |  |
|  | DimMaterial |  |  |  |  |  |  |  |  |  | FactMaterialConsumption |  |  |  |  |  |  |  |  |  |  |  |  |  |  |
|  |  |  |  |  |  | → |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |
|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  | DimWorkPackage |  |  |  |  |
|  |  |  |  |  |  |  |  |  |  |  | FactProjectCost |  |  |  |  |  |  |  |  | → |  |  |  |  |  |
|  | DimContractor |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |
|  |  |  |  |  |  | → |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |
|  |  |  |  |  |  |  |  |  |  |  | FactProgressTracking |  |  |  |  |  |  |  |  |  |  |  |  |  |  |
|  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  | SecurityUserProject |  |  |  |  |
|  | DimCostCategory |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  | → |  |  |  |  |  |
|  |  |  |  |  |  | → |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |
|  | Design principle: single-direction relationships from dimensions to facts; SecurityUserProject bridge controls RLS by ProjectKey/CompanyCode. |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |  |

## Sheet: ETL_Swimlane_v2

|  | ETL SWIMLANE FLOW - SOURCE TO REPORT |  |  |  |  |  |  |  |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
|  | Lane | Step-1 | Step-2 | Step-3 | Step-4 | Step-5 | Step-6 | Step-7 |
|  | Source Systems | Extract ERP/PMIS | Extract Procurement | Extract Cost | Watermark Check | Raw Load | - | - |
|  | Data Engineering | Raw Validation | UOM Standardize | Master Mapping | Dedupe & Null Key | Load Clean | Build Semantic Fact/Dim | Publish Dataset Model |
|  | BI Layer | Dataset Refresh | Run DAX Calc | Apply RLS | Render Dashboards | Data Alert Rules | Usage Metrics | Stakeholder Distribution |
|  | Governance | DQ Critical Check | Variance Control | Security Audit | Sign-off Gate | Release Note | Post-Deploy Monitor | Monthly Review |
|  | SLA target: end-to-end pipeline <= 45 phút/refresh cycle; critical DQ issue must block publish and raise alert to PMO + Data Team. |  |  |  |  |  |  |  |

## Sheet: Traceability_Matrix_v2

| KPI Code | KPI Name | DAX Measure | Source Table(s) | Key Source Column(s) | Target Dashboard Visual | Test Case ID | Owner | Status |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| KPI-01 | Total Material Quantity | [Total Material Quantity] | dbo.MaterialIssueLine + dbo.MaterialReturnLine | IssuedQty, ReturnQty | Material Consumption Control / KPI Card | TC-KPI-001 | BI Dev Lead | Ready |
| KPI-02 | Material Overuse % | [Material Overuse %] | dbo.BOMNorm + dbo.MaterialIssueLine | NormQty, IssuedQty | Material Consumption Control / Heatmap | TC-KPI-002 | Data Engineer | Ready |
| KPI-03 | Actual Cost | [Actual Cost] | dbo.CostLedger | ActualAmount | Cost vs Budget / KPI Card | TC-KPI-003 | Finance BI Analyst | Ready |
| KPI-04 | Budget Cost | [Budget Cost] | dbo.BudgetBaseline | BudgetAmount | Cost vs Budget / KPI Card | TC-KPI-004 | Finance BI Analyst | Ready |
| KPI-05 | Budget Variance % | [Budget Variance %] | dbo.CostLedger + dbo.BudgetBaseline | ActualAmount, BudgetAmount | Executive / Matrix + Card | TC-KPI-005 | PMO BI Team | In Review |
| KPI-08 | SPI | [SPI] | dbo.ProgressDaily | EarnedValue, PlannedValue | Progress & Delay Risk / KPI + Trend | TC-KPI-008 | Planning BI Analyst | In Review |
| KPI-09 | CPI | [CPI] | dbo.ProgressDaily + dbo.CostLedger | EarnedValue, ActualAmount | Executive / KPI Card | TC-KPI-009 | Planning BI Analyst | In Review |
| KPI-10 | Delay Days | [Delay Days] | dbo.ProgressDaily | DelayDays | Progress & Delay Risk / Milestone Table | TC-KPI-010 | Site Reporting Team | Ready |

## Sheet: RLS_Heatmap_v2

| Role | Executive Page | Cost Pages | Material Pages | Progress Pages | Contractor Detail | Underlying Data Export |
| --- | --- | --- | --- | --- | --- | --- |
| Admin | Full | Full | Full | Full | Full | Allowed |
| Project Manager | Project Scope | Project Scope | Project Scope | Project Scope | Limited | Allowed |
| Site Engineer | No Access | No Access | Project Scope | Project Scope | No Access | Restricted |
| Contractor Viewer | No Access | Own Company | Own Company | Own Company | Own Company | Blocked |
| Heatmap giúp stakeholder bảo mật xác nhận nhanh phạm vi truy cập theo role trước khi publish app trên Power BI Service. |  |  |  |  |  |  |

## Sheet: Refresh_Monitor_v2

| RunDateTime | Duration_Min | Rows_Processed_Million | DQ_Critical_Issues |
| --- | --- | --- | --- |
| 2026-02-04 06:00 | 34 | 12.5 | 0 |
| 2026-02-04 09:00 | 36 | 13.1 | 0 |
| 2026-02-04 12:00 | 39 | 13.8 | 1 |
| 2026-02-04 15:00 | 37 | 13 | 0 |
| 2026-02-05 06:00 | 35 | 12.9 | 0 |
| 2026-02-05 09:00 | 33 | 12.3 | 0 |
| 2026-02-05 12:00 | 41 | 14 | 1 |
| 2026-02-05 15:00 | 38 | 13.4 | 0 |
| 2026-02-06 06:00 | 32 | 12.1 | 0 |
| 2026-02-06 09:00 | 34 | 12.6 | 0 |
| 2026-02-06 12:00 | 36 | 12.9 | 0 |
| 2026-02-06 15:00 | 35 | 12.7 | 0 |

## Sheet: Header

| Mục | Nội dung |
| --- | --- |
| Tên dự án | Enterprise Construction Intelligence Platform (ECIP) - Phase 1 |
| Khách hàng | Tổng Công ty Hạ tầng ABC |
| Phạm vi triển khai | Thiết kế chi tiết semantic model, dashboard, KPI, RLS cho 20 dự án xây dựng; dùng trực tiếp cho đội developer triển khai. |
| Nguồn dữ liệu chính | SQL Server: ERP, PMIS, Procurement, Cost Control, Identity |
| Công nghệ sử dụng | SQL Server 2022, SSIS, Power Query M, DAX, XMLA Endpoint, Power BI Service |
| Phiên bản tài liệu | v2.3 - Detail Design (DashboardCatalog implement-ready) |
| Người tạo / Ngày tạo | Senior BI Solution Architect / 2026-02-10 |
| Tiêu chuẩn phát triển | Naming: Fact*/Dim*; DateKey dạng YYYYMMDD; model star schema |

## Sheet: History

| Version | Ngày chỉnh sửa | Người chỉnh sửa | Mô tả thay đổi |
| --- | --- | --- | --- |
| v0.1 | 2026-01-18 | BI Architect | Khởi tạo phạm vi chi tiết mô hình dữ liệu. |
| v0.4 | 2026-01-30 | Data Engineer Lead | Bổ sung mapping source-to-semantic cho module vật tư và chi phí. |
| v0.7 | 2026-02-05 | Power BI Lead | Thiết kế dashboard layout và visual specification. |
| v0.9 | 2026-02-08 | Security Architect | Bổ sung role matrix và hướng dẫn RLS. |
| v1.0 | 2026-02-10 | Senior BI Solution Architect | Phát hành tài liệu detail cho triển khai. |
| v2.0 | 2026-02-10 | Senior BI Solution Architect | Bổ sung ERD visual, ETL swimlane, traceability matrix, RLS heatmap, refresh monitoring charts. |
| v2.1 | 2026-02-10 | Senior BI Solution Architect | Bổ sung Reading Path + hyperlink điều hướng từ Overview tới các sheet thiết kế chi tiết theo thứ tự implement. |
| v2.2 | 2026-02-10 | Senior BI Solution Architect | Bổ sung mô tả chức năng chi tiết cho từng module (must-have), thêm Module_Function_Spec_v2 và cập nhật luồng đọc. |
| v2.3 | 2026-02-10 | Senior BI Solution Architect | Nâng cấp DashboardCatalog lên mức implement: bổ sung visual contract, measure set, filter/interactions, UAT criteria và target hiệu năng. |

## Sheet: Overview

| Hạng mục | Mô tả chi tiết |  |  |  |  |
| --- | --- | --- | --- | --- | --- |
| Kiến trúc end-to-end | SQL Server OLTP -> SSIS ETL -> DW_Raw -> DW_Clean -> DW_Semantic (star schema) -> Power BI Dataset -> Power BI App. |  |  |  |  |
| Luồng dữ liệu | Dimension full-load 01:00 hằng ngày; fact incremental mỗi 2 giờ theo watermark LastUpdatedDatetime; refresh dataset 06/09/12/15/18/21h. |  |  |  |  |
| Phân tầng Raw | Giữ dữ liệu gần nguồn + ETLBatchID + ExtractedAtUTC để audit/replay. |  |  |  |  |
| Phân tầng Clean | Chuẩn hóa UOM, mã master data, chuẩn email UPN, xử lý duplicate business key. |  |  |  |  |
| Phân tầng Semantic | Star schema surrogate key int, quan hệ single-direction, ưu tiên measure để tối ưu model size. |  |  |  |  |
| ASCII architecture | [SQL Server OLTP]<br> ERP \| PMIS \| Procurement \| Cost \| Identity<br>                \|<br>          [SSIS Orchestration]<br>                \|<br>      [DW_Raw] -> [DW_Clean] -> [DW_Semantic]<br>                               \|<br>                    [Power BI Dataset]<br>                               \|<br>         [Executive][Material][Cost][Progress]<br>                               \|<br>                 [Power BI Service + RLS] |  |  |  |  |
|  | #'00_ReadMe_Visual'!A1 |  |  |  |  |
|  | #'ERD_Star_Visual_v2'!A1 |  |  |  |  |
|  | #'ETL_Swimlane_v2'!A1 |  |  |  |  |
|  | #'Overview'!A1 |  |  |  |  |
|  | #'Modules'!A1 |  |  |  |  |
|  | #'DashboardCatalog'!A1 |  |  |  |  |
|  | #'DashboardLayoutSpec'!A1 |  |  |  |  |
|  | #'KPI'!A1 |  |  |  |  |
|  | #'Traceability_Matrix_v2'!A1 |  |  |  |  |
|  | #'DataModel'!A1 |  |  |  |  |
|  | #'ModelRelationships'!A1 |  |  |  |  |
|  | #'SourceMapping'!A1 |  |  |  |  |
|  | #'DAXLogic'!A1 |  |  |  |  |
|  | #'BusinessRules'!A1 |  |  |  |  |
|  | #'RLS_Heatmap_v2'!A1 |  |  |  |  |
|  | #'RLS'!A1 |  |  |  |  |
|  | #'Refresh_Monitor_v2'!A1 |  |  |  |  |
| NAVIGATION FROM OVERVIEW |  |  |  |  |  |
| Step | Đi tới sheet | Đọc để làm gì | Input | Output | Ai nên đọc |
| 1 | Modules | Nắm phạm vi từng module | Overview | Module_Function_Spec_v2 | PMO + Business |
| 2 | Module_Function_Spec_v2 | Hiểu chi tiết module cần làm gì ở mức chức năng | Modules | DashboardCatalog | BA + Dev Lead |
| 3 | DashboardCatalog | Hiểu dashboard mục tiêu | Function spec | DashboardLayoutSpec | Report Designer |
| 4 | DashboardLayoutSpec | Chốt visual-level design | DashboardCatalog | KPI | Power BI Dev |
| 5 | KPI | Chốt định nghĩa đo lường | Layout spec | Traceability_Matrix_v2 | Business + QA |
| 6 | Traceability_Matrix_v2 | Trace KPI sang DAX/source/test | KPI | DataModel | Dev + QA |
| 7 | DataModel | Chốt field-level model | Traceability | SourceMapping | Data Engineer |
| 8 | SourceMapping | Chốt transform source -> semantic | DataModel | DAXLogic | ETL Dev |
| 9 | DAXLogic | Chốt công thức implement | Mapping | BusinessRules | Power BI Dev |
| 10 | BusinessRules | Chốt rule nghiệp vụ/ngoại lệ | DAX | RLS | Business + QA |
| 11 | RLS | Chốt phân quyền dữ liệu | BusinessRules | Refresh_Monitor_v2 | Security + Admin |
| 12 | Refresh_Monitor_v2 | Theo dõi vận hành sau triển khai | All | Runbook | Operations |

## Sheet: Modules

| Module ID | Subject Area | Mục tiêu nghiệp vụ | Persona chính | Input dataset (SQL) | Output dashboard | KPI trọng tâm | Chức năng chi tiết cần triển khai (Must-Have) | Integration / Dependencies | Definition of Done (DoD) | Tần suất refresh | SLA |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| M01 | Material Management | Kiểm soát tiêu thụ vật tư theo định mức BOM và hao hụt theo nhà thầu/site. | Project Manager; Site Engineer; Procurement | MaterialMaster, MaterialIssueLine, MaterialReturnLine, BOMNorm | Material Consumption Control | Total Material Qty; Overuse %; Return Rate | 1) Theo dõi nhập-xuất-trả theo ngày/công trình/work package<br>2) Tính NetQty, OverNormQty ở mức transaction<br>3) Drillthrough tới chứng từ nguồn<br>4) Cảnh báo overuse theo ngưỡng 5/10%<br>5) Phân tích mix vật tư theo nhóm + contractor | Phụ thuộc BOM approved, DimMaterial chuẩn hóa, mapping WorkPackage; đồng bộ với module tiến độ để kiểm tra mức tiêu hao theo khối lượng thực hiện. | Dashboard hiển thị đúng KPI theo test case TC-KPI-001/002; giao dịch thiếu BOM được tách trạng thái Data Issue; PM drill tới DocNo được. | 2 giờ/lần | Freshness <= 2h |
| M02 | Construction Progress | So sánh baseline vs actual theo work package/milestone và cảnh báo delay risk. | Planning Engineer; PM | BaselineSchedule, ProgressDaily, WorkPackagePlan | Progress & Delay Risk | Planned vs Actual %; Delay Days; SPI | 1) So sánh PlannedQty vs ActualCompletedQty theo tuần<br>2) Tính DelayDays và phân tầng risk level<br>3) Theo dõi milestone critical path<br>4) Cảnh báo SPI < 0.95<br>5) Drilldown Project -> Phase -> WorkPackage | Phụ thuộc DimDate, DimWorkPackage và dữ liệu baseline được khóa phiên bản; dùng cùng chuẩn ProjectKey với cost/material để phân tích liên thông. | Trend line, milestone table, risk matrix khớp dữ liệu nguồn; quy tắc cap tiến độ <=100% hoạt động đúng; delay âm được ép 0. | 2 giờ/lần | Freshness <= 2h |
| M03 | Cost & Budget | Giám sát chi phí thực tế, ngân sách, cam kết chi và change order. | Finance Controller; PM; PMO | CostLedger, BudgetBaseline, CommitmentLedger, ChangeOrder | Cost vs Budget Deep Dive | Actual Cost; Budget Variance %; CPI | 1) Tổng hợp Budget/Actual/Committed theo category<br>2) Tính Variance và Variance% theo nhiều cấp<br>3) Waterfall phân rã nguyên nhân chênh lệch<br>4) Theo dõi ChangeOrder tác động ngân sách<br>5) Cảnh báo >5% (vàng), >10% (đỏ) | Phụ thuộc chuẩn CostCategory hierarchy, quy đổi tiền tệ VND và loại bỏ reversal; cần liên kết EV từ module tiến độ để tính CPI. | KPI chi phí đối soát với finance ledger sai lệch <=0.5%; matrix drilldown đầy đủ 3 tầng; màu cảnh báo đúng ngưỡng. | 2 giờ/lần | Freshness <= 2h |
| M04 | Contractor Performance | Đánh giá năng suất và tuân thủ SLA nhà thầu. | Contract Manager; PMO | ContractorMaster, ContractorKPI, DeliveryPerformance | Contractor Scorecard | Productivity Index; On-time Delivery % | 1) Xếp hạng nhà thầu theo productivity/cost/schedule<br>2) Tính On-time delivery theo ETA ±1 ngày<br>3) Theo dõi lỗi SLA theo loại vi phạm<br>4) Benchmark giữa các nhà thầu cùng loại<br>5) Cảnh báo nhà thầu dưới ngưỡng tier B | Phụ thuộc dữ liệu labor hours, delivery log và mapping contractor-company cho RLS; dùng dữ liệu kết hợp từ material + progress + cost. | Scorecard tái lập được theo tháng; rule loại bản ghi thiếu labor hour hoạt động đúng; contractor external chỉ thấy dữ liệu own company. | Ngày | Daily 06:00 |
| M05 | Acceptance & Billing | Đối soát khối lượng nghiệm thu và thanh toán theo đợt. | QS; Site Engineer; Finance | AcceptanceMinutes, BillingProgress, PaymentCertificate | Acceptance & Billing Tracker | Accepted Qty; Pending Billing Amount | 1) Theo dõi accepted qty theo giai đoạn<br>2) So sánh thi công thực tế vs nghiệm thu<br>3) Theo dõi hồ sơ thanh toán pending/approved/paid<br>4) Cảnh báo quá hạn thanh toán theo SLA<br>5) Drillthrough tới biên bản nghiệm thu | Phụ thuộc chứng từ nghiệm thu chuẩn hóa và status workflow thanh toán; cần liên kết với tiến độ để tránh nghiệm thu vượt thực tế. | Báo cáo thể hiện đúng trạng thái hồ sơ; pending amount tính đúng theo kỳ; drillthrough biên bản/phiếu thanh toán hoạt động. | Ngày | Daily 06:00 |

## Sheet: Module_Function_Spec_v2

| Module ID | Function ID | Function Name | Mô tả chi tiết cần làm | Input chính | Logic xử lý chính | Output / Visual | Priority | Owner | Acceptance Criteria |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| M01 | M01-F01 | Material Ledger Consolidation | Hợp nhất phiếu xuất, phiếu trả, điều chỉnh tồn theo ngày và WorkPackage. | MaterialIssueLine, MaterialReturnLine | NetQty = Issued - Return; loại chứng từ cancelled. | Table giao dịch + KPI NetQty | High | Data Engineer | Số liệu khớp tổng source lệch <=0.5% |
| M01 | M01-F02 | Overuse Detection | Tính lượng vượt định mức theo BOM version hiệu lực. | BOMNorm + NetQty | OverNormQty = max(NetQty - NormQty,0). | KPI Overuse % + Heatmap | High | BI Developer | Ngưỡng cảnh báo 5/10% hiển thị đúng màu |
| M01 | M01-F03 | Material Mix Analysis | Phân tích cơ cấu vật tư theo nhóm / dự án / nhà thầu. | DimMaterial + FactMaterialConsumption | Tính share theo filter context. | Donut + stacked column | Medium | BI Analyst | Top nhóm vật tư đúng theo filter |
| M01 | M01-F04 | Document Drillthrough | Drillthrough từ KPI/heatmap xuống chứng từ nguồn. | SourceDocNo, ProjectKey | Giữ grain transaction để trace. | Drillthrough page | High | BI Developer | Click 1 dòng mở đúng chứng từ |
| M02 | M02-F01 | Progress Baseline Comparison | So sánh tiến độ baseline vs actual theo tuần. | ProgressDaily, WorkPackagePlan | Planned%/Actual% theo BaselineQty. | Line trend planned vs actual | High | Planning BI Analyst | Trend khớp bảng tiến độ nguồn |
| M02 | M02-F02 | Delay Risk Scoring | Chấm điểm rủi ro theo DelayDays + SPI. | DelayDays, SPI | Risk = High/Medium/Low theo rule BR. | Risk matrix | High | BI Developer | Rule biên 7/14 ngày đúng |
| M02 | M02-F03 | Milestone Tracking | Theo dõi milestone critical với cảnh báo quá hạn. | Milestone schedule | DelayDays = max(0, Forecast-Plan). | Milestone warning table | High | Planning Engineer | Milestone quá hạn tô màu đỏ |
| M02 | M02-F04 | WorkPackage Drill Path | Drill Project -> Phase -> WorkPackage để khoanh vùng chậm. | DimWorkPackage, FactProgressTracking | Hierarchy filter context chính xác. | Matrix drilldown | Medium | BI Developer | Drill path không mất ngữ cảnh |
| M03 | M03-F01 | Budget-Actual Consolidation | Tổng hợp budget, actual, committed theo category và kỳ. | BudgetBaseline, CostLedger, CommitmentLedger | Loại reversal, quy đổi VND. | KPI cards + matrix | High | Finance BI Analyst | Đối soát finance pass <=0.5% |
| M03 | M03-F02 | Variance Waterfall | Phân rã nguyên nhân chênh lệch ngân sách. | FactProjectCost, DimCostCategory | Variance = Actual - Budget theo driver. | Waterfall chart | High | BI Analyst | Top driver đúng với matrix |
| M03 | M03-F03 | Alerting Rules | Thiết lập cảnh báo vượt 5%/10%. | Budget Variance % | Rule màu vàng/đỏ theo threshold. | Card + conditional matrix | High | BI Developer | Màu cảnh báo đúng ngưỡng |
| M03 | M03-F04 | Change Order Impact | Phân tích tác động phát sinh lên ngân sách. | ChangeOrder | Theo dõi delta trước/sau CO. | Bar + trend line | Medium | PMO Analyst | CO approved mới được tính |
| M04 | M04-F01 | Contractor Productivity Score | Tính năng suất theo sản lượng/giờ công. | ActualCompletedQty, LaborHours | Productivity = Qty/LaborHours; loại zero hours. | Scorecard KPI | High | Contract Manager | Top/Bottom contractor đúng logic |
| M04 | M04-F02 | On-time Delivery SLA | Đo tỷ lệ giao hàng đúng hạn ETA ±1 ngày. | DeliveryPerformance | On-time count / total count. | SLA bar chart | High | Procurement Analyst | Tỷ lệ đúng với log giao nhận |
| M04 | M04-F03 | Contractor Benchmark | So sánh nhà thầu cùng nhóm công việc. | DimContractor, KPI scores | Ranking theo weighted score. | Benchmark matrix | Medium | BI Analyst | Ranking ổn định theo kỳ |
| M04 | M04-F04 | External Access Scope | Giới hạn nhà thầu chỉ thấy dữ liệu own company. | SecurityUserProject, CompanyCode | RLS filter theo company. | External contractor view | High | Security Admin | Tài khoản ngoài chỉ thấy dữ liệu hợp lệ |
| M05 | M05-F01 | Acceptance Progress Tracking | Theo dõi accepted qty theo phase/work package. | AcceptanceMinutes | AcceptedQty tổng hợp theo kỳ. | Acceptance trend | High | QS Analyst | Accepted qty khớp biên bản |
| M05 | M05-F02 | Construction vs Acceptance Reconcile | Đối soát thi công thực tế với nghiệm thu. | FactProgressTracking + Acceptance | Variance giữa actual completed và accepted. | Variance table | High | Site Engineer | Sai lệch vượt ngưỡng được cảnh báo |
| M05 | M05-F03 | Billing Workflow Monitor | Theo dõi trạng thái pending/approved/paid hồ sơ. | BillingProgress, PaymentCertificate | Status lifecycle theo ngày xử lý. | Workflow funnel + table | High | Finance Ops | Pending quá SLA hiển thị đỏ |
| M05 | M05-F04 | Payment Delay Alert | Cảnh báo hồ sơ thanh toán quá hạn SLA. | DueDate, PaymentDate | Delay = max(0, PaymentDate-DueDate). | Delay alert dashboard | Medium | Finance Controller | Danh sách quá hạn đúng theo source |

## Sheet: DashboardLayoutSpec

| Dashboard | Page | Visual ID | Visual Type | X | Y | W | H | Field Binding | Visual-level Filter | Interaction/Drill | Ghi chú triển khai |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| Executive Portfolio Overview | Portfolio Summary | V01 | Card | 20 | 20 | 180 | 80 | [Budget Cost] | Year=Current | Cross-highlight | KPI ngân sách |
| Executive Portfolio Overview | Portfolio Summary | V02 | Card | 220 | 20 | 180 | 80 | [Actual Cost] | Year=Current | Cross-highlight | KPI thực chi |
| Executive Portfolio Overview | Portfolio Summary | V03 | Card | 420 | 20 | 180 | 80 | [Budget Variance %] | Year=Current | Cross-highlight | KPI chênh lệch % |
| Executive Portfolio Overview | Portfolio Summary | V04 | Column | 20 | 130 | 700 | 260 | Axis:Project; Value:[Actual Cost],[Budget Cost] | TopN15 theo Actual Cost | Select project filters matrix | So sánh actual vs budget |
| Executive Portfolio Overview | Portfolio Summary | V05 | Line | 740 | 130 | 580 | 260 | Axis:Month; Value:[Actual Cost] | Last 18 months | Select month filters matrix | Xu hướng dòng tiền |
| Executive Portfolio Overview | Portfolio Summary | V06 | Matrix | 20 | 410 | 1300 | 280 | Rows:Project; Cols:CostCategory; Values:[Budget Variance] | [Budget Variance %] > 0 | Drilldown enabled | Top overspend |
| Material Consumption Control | Material Deep Dive | V03 | Donut | 20 | 120 | 360 | 260 | Legend:MaterialGroup; Value:[Total Material Quantity] | Exclude UNCLASSIFIED | Select group filters table | Tỷ trọng vật tư |
| Material Consumption Control | Material Deep Dive | V05 | Heatmap | 940 | 120 | 380 | 260 | X:Contractor; Y:WorkPackage; Value:[Material Overuse %] | Overuse% > 0 | Select cell drills table | Điểm nóng overuse |
| Cost vs Budget Deep Dive | Cost Analysis | V01 | Waterfall | 20 | 120 | 700 | 270 | Category:CostDriver; Y:[Budget Variance] | Year=selected | Select bar filters matrix | Variance bridge |
| Cost vs Budget Deep Dive | Cost Analysis | V04 | Matrix | 20 | 410 | 1300 | 280 | Rows:Project->Category->Contractor; Values:Budget,Actual,Variance% | No filter | Full drill path | Bảng đối soát |
| Progress & Delay Risk | Schedule Monitoring | V01 | Line | 20 | 120 | 720 | 260 | Axis:Week; Values:[Planned Progress %],[Actual Progress %] | Last 26 weeks | Select week filters milestones | Xu hướng tiến độ |
| Progress & Delay Risk | Schedule Monitoring | V03 | Table | 20 | 400 | 1300 | 290 | Milestone,PlannedDate,ForecastDate,DelayDays,Owner | DelayDays >= 3 | Conditional format by DelayDays | Milestone cảnh báo |

## Sheet: DashboardCatalog

| Dashboard ID | Dashboard / Page | Module | Business Objective | Primary Persona | Decision Supported | Required Input Tables | Mandatory Visual Contract | Core Measures (DAX) | Default Filters & Slicers | Interaction / Drill Rules | Layout Spec Reference | RLS & Data Scope Notes | Performance Target | UAT Acceptance Criteria | Owner / Status |
| --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- | --- |
| DB-01 | Executive Portfolio Overview / Portfolio Summary | M02 + M03 | Cung cấp bức tranh cấp điều hành về ngân sách, tiến độ và rủi ro portfolio. | CEO, COO, PMO Director | Quyết định phân bổ lại nguồn lực, ưu tiên dự án cần can thiệp. | FactProjectCost, FactProgressTracking, DimProject, DimDate, DimCostCategory | 6 KPI cards (Budget/Actual/Variance%/SPI/CPI/Risk Projects) + 1 clustered column + 1 line trend + 1 overspend matrix. | [Budget Cost], [Actual Cost], [Budget Variance], [Budget Variance %], [SPI], [CPI], [Delay Risk Level] | Default Year=Current Year; TopN 15 projects by Actual Cost; slicers: Region, Project Type, PM. | Click bar project filters matrix + KPI context; matrix supports drill Project -> Cost Category -> Contractor. | DashboardLayoutSpec: V01..V06 | RLS theo ProjectKey. Role Site Engineer không được publish page này trong app role-based. | P95 query < 4 giây; render first view < 7 giây với 15 projects. | 1) KPI khớp test set finance/progress<br>2) Top overspend đúng sort<br>3) Drilldown không mất filter context | PMO BI Team / Implemented (Phase-1) |
| DB-02 | Material Consumption Control / Material Deep Dive | M01 | Kiểm soát tiêu thụ vật tư và phát hiện vượt định mức theo contractor/work package. | Project Manager, Site Engineer, Procurement | Quyết định điều chỉnh cấp phát vật tư, kiểm tra hao hụt bất thường, audit chứng từ. | FactMaterialConsumption, DimMaterial, DimProject, DimContractor, DimWorkPackage, DimDate | 4 KPI cards + donut material mix + stacked column by project + overuse heatmap + transaction table (drillthrough). | [Total Material Quantity], [Norm Quantity], [OverNorm Quantity], [Material Overuse %], [Return Rate] | Default Date=Last 30 days; exclude UNCLASSIFIED on mix chart; optional slicer ContractorType. | Click heatmap cell -> drillthrough transaction detail (DocNo level); sync slicer across page visuals. | DashboardLayoutSpec: V01..V06 (Material Deep Dive) | RLS: ProjectManager/SiteEngineer theo project mapping; ContractorViewer chỉ thấy own CompanyCode. | P95 query < 4 giây; drillthrough detail page < 6 giây (90-day window). | 1) Overuse% = OverNorm/Norm đúng theo test TC-KPI-002<br>2) Drillthrough mở đúng SourceDocNo<br>3) Filter đồng bộ các visual | Procurement BI Squad / Implemented (Phase-1) |
| DB-03 | Cost vs Budget Deep Dive / Cost Analysis | M03 | Phân rã nguyên nhân chênh lệch ngân sách theo category, contractor và timeline. | Finance Controller, PM, PMO | Quyết định cắt giảm chi phí, xử lý nhóm chi vượt mức và đánh giá tác động change order. | FactProjectCost, DimCostCategory, DimContractor, DimProject, DimDate | 4 KPI cards + waterfall variance bridge + bar variance by category + treemap contractor + matrix drill path. | [Budget Cost], [Actual Cost], [Budget Variance], [Budget Variance %], [ChangeOrder Impact] | Default Year=current; visual filter [Budget Variance %] > 0 cho bảng overspend; slicers: Region, CostType. | Select waterfall step filters matrix; matrix drill path Project -> Category -> Contractor; export summary only. | DashboardLayoutSpec: V01..V04 (Cost Analysis) | RLS theo project; category Contingency không áp dụng cảnh báo màu vượt chi phí. | P95 query < 4 giây với max 24 tháng dữ liệu; matrix expand level-3 < 6 giây. | 1) Variance waterfall tổng bằng KPI variance<br>2) Category top-N đúng sort<br>3) Cảnh báo 5/10% đúng màu | Finance BI Analyst / Implemented (Phase-1) |
| DB-04 | Progress & Delay Risk / Schedule Monitoring | M02 | Theo dõi tiến độ thực tế vs kế hoạch và đánh giá rủi ro trễ milestone. | Planning Engineer, PM | Quyết định ưu tiên gói công việc cần bù tiến độ và xử lý rủi ro cao. | FactProgressTracking, DimWorkPackage, DimProject, DimDate, DimContractor | 4 KPI cards + planned/actual trend line + risk matrix + milestone warning table. | [Planned Progress %], [Actual Progress %], [Delay Days], [SPI], [Delay Risk Level] | Default Last 26 weeks; milestone table filter DelayDays >= 3; slicers: Region, Phase, Contractor. | Select risk bubble filters milestone table; drill Project -> Phase -> WorkPackage from table. | DashboardLayoutSpec: V01..V03 (Schedule Monitoring) | RLS theo project; SiteEngineer truy cập page này, không truy cập cost pages. | P95 query < 4 giây; risk matrix interaction < 2 giây cho selection event. | 1) Planned/Actual trend khớp source<br>2) DelayDays âm được ép 0<br>3) Risk level rule High/Medium/Low đúng biên | Planning BI Analyst / Implemented (Phase-1) |
| DB-05 | Contractor Scorecard / Contractor Benchmark | M04 | Đánh giá hiệu suất nhà thầu theo productivity, SLA và mức độ tuân thủ. | Contract Manager, PMO | Quyết định lựa chọn nhà thầu cho giai đoạn tiếp theo và kế hoạch cải thiện SLA. | DimContractor, FactProgressTracking, FactMaterialConsumption, DeliveryPerformance | KPI tier cards + ranking table + SLA trend + benchmark matrix (planned). | [Contractor Productivity Index], [On-time Delivery %], [SLA Violation Count] | Default last 3 months; slicers: ContractorType, Region, Project. | Drill contractor -> project -> work package; tooltip hiển thị SLA detail. | Layout pending (next sprint) - placeholder in DashboardLayoutSpec | ContractorViewer chỉ nhìn own company; internal roles có đầy đủ benchmark cross-contractor. | P95 query < 5 giây sau khi triển khai page chuyên biệt. | 1) Ranking stable theo weighted score<br>2) External role không nhìn cross-company benchmark | Contract BI Product Owner / Planned (Sprint+2) |
| DB-06 | Acceptance & Billing Tracker / Acceptance to Payment | M05 | Theo dõi vòng đời nghiệm thu -> thanh toán và phát hiện hồ sơ quá hạn SLA. | QS, Site Engineer, Finance Ops | Quyết định đẩy nhanh hồ sơ pending và giảm tồn đọng thanh toán. | AcceptanceMinutes, BillingProgress, PaymentCertificate, FactProgressTracking, DimDate | KPI accepted qty/pending amount + workflow funnel + pending list + delay alert table (planned). | [Accepted Qty], [Pending Billing Amount], [Payment Delay Days], [Billing SLA Breach %] | Default current month + previous month; slicers: Project, Phase, BillingStatus. | Click funnel status filters pending list; drill to certificate/document detail. | Layout pending (next sprint) - placeholder in DashboardLayoutSpec | RLS theo project + role; ContractorViewer không truy cập billing amount chi tiết công ty nội bộ. | P95 query < 5 giây với data window 12 tháng. | 1) Pending amount đối soát AP<br>2) Delay alert đúng SLA rule<br>3) Drill tới chứng từ thanh toán chính xác | Finance Ops BI / Planned (Sprint+3) |

## Sheet: KPI

| KPI Code | KPI Name | Business Definition | DAX Logic | Unit | Granularity | Threshold | Owner | Validation Rule |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| KPI-01 | Total Material Quantity | Tổng khối lượng vật tư xuất dùng ròng. | Total Material Quantity = SUMX(FactMaterialConsumption, FactMaterialConsumption[IssuedQty]-FactMaterialConsumption[ReturnQty]) | Tấn/m3/cây | Project-Material-Date | MoM > +15%: Yellow; >+25%: Red | Procurement Lead | Đối soát tổng theo phiếu xuất-trả |
| KPI-02 | Material Overuse % | Tỷ lệ vượt định mức BOM. | Material Overuse % = DIVIDE([OverNorm Quantity], [Norm Quantity]) | % | Project-WorkPackage-Material | >10% Red | Site Engineering Manager | NormQty=0 thì BLANK và log DQ |
| KPI-03 | Actual Cost | Tổng chi phí thực tế. | Actual Cost = SUM(FactProjectCost[ActualAmount]) | VND | Project-Date-Category | Theo baseline dự án | Finance Controller | Đối soát CostLedger |
| KPI-04 | Budget Cost | Tổng ngân sách approved baseline. | Budget Cost = SUM(FactProjectCost[BudgetAmount]) | VND | Project-Date-Category | - | PMO Cost Team | Chỉ lấy baseline latest approved |
| KPI-05 | Budget Variance % | Tỷ lệ vượt/tiết kiệm ngân sách. | Budget Variance % = DIVIDE([Actual Cost]-[Budget Cost], [Budget Cost]) | % | Project-Date | >5% Yellow; >10% Red | PMO Director | Budget=0 thì BLANK |
| KPI-08 | SPI | Schedule Performance Index. | SPI = DIVIDE([Earned Value], [Planned Value]) | Index | Project-Week | <0.95 Red | PM | Đồng nhất kỳ EV/PV |
| KPI-09 | CPI | Cost Performance Index. | CPI = DIVIDE([Earned Value], [Actual Cost]) | Index | Project-Month | <0.95 Red | Finance PM | Actual Cost=0 thì BLANK |
| KPI-10 | Delay Days | Số ngày trễ tiến độ dự báo. | Delay Days = MAX(FactProgressTracking[DelayDays]) | Ngày | Project-Milestone | >7 Red | Planning Engineer | Delay âm ép về 0 tại ETL |

## Sheet: DataModel

| Table | Column | Data Type | Key Type | Nullable | Business Meaning | Rule / Note |
| --- | --- | --- | --- | --- | --- | --- |
| FactMaterialConsumption | MaterialTxnKey | bigint | PK | No | Khóa surrogate giao dịch vật tư | Generated in DW |
| FactMaterialConsumption | ProjectKey | int | FK->DimProject | No | Liên kết dự án | Lookup by ProjectCode |
| FactMaterialConsumption | MaterialKey | int | FK->DimMaterial | No | Liên kết vật tư | Lookup by MaterialCode |
| FactMaterialConsumption | ContractorKey | int | FK->DimContractor | Yes | Liên kết nhà thầu | Unknown=-1 |
| FactMaterialConsumption | DateKey | int | FK->DimDate | No | Ngày phát sinh | YYYYMMDD |
| FactMaterialConsumption | WorkPackageKey | int | FK->DimWorkPackage | Yes | Gói công việc | Unknown=-1 |
| FactMaterialConsumption | IssuedQty | decimal(18,3) | Measure | No | Khối lượng xuất | >=0 |
| FactMaterialConsumption | ReturnQty | decimal(18,3) | Measure | No | Khối lượng trả | >=0 |
| FactMaterialConsumption | NetQty | decimal(18,3) | Measure | No | IssuedQty - ReturnQty | Computed ETL |
| FactMaterialConsumption | ActualCost | decimal(18,2) | Measure | No | Chi phí vật tư thực tế | NetQty * UnitPrice |
| FactMaterialConsumption | NormQty | decimal(18,3) | Measure | Yes | Định mức BOM | Join BOMNorm |
| FactMaterialConsumption | OverNormQty | decimal(18,3) | Measure | Yes | Khối lượng vượt định mức | Max(0, Net-Norm) |
| FactMaterialConsumption | SourceDocNo | nvarchar(50) | Degenerate | Yes | Số chứng từ nguồn | Dùng drillthrough |
| FactMaterialConsumption | LastUpdatedDatetime | datetime2 | Audit | No | Watermark incremental | UTC |
| FactProjectCost | CostTxnKey | bigint | PK | No | Khóa surrogate giao dịch chi phí | Generated in DW |
| FactProjectCost | ProjectKey | int | FK->DimProject | No | Liên kết dự án | Lookup |
| FactProjectCost | ContractorKey | int | FK->DimContractor | Yes | Liên kết nhà thầu | Unknown=-1 |
| FactProjectCost | DateKey | int | FK->DimDate | No | Ngày hạch toán | YYYYMMDD |
| FactProjectCost | CostCategoryKey | int | FK->DimCostCategory | No | Nhóm chi phí | Lookup |
| FactProjectCost | BudgetAmount | decimal(18,2) | Measure | No | Ngân sách baseline | Latest approved |
| FactProjectCost | ActualAmount | decimal(18,2) | Measure | No | Chi phí thực tế | Exclude reversal |
| FactProjectCost | CommittedAmount | decimal(18,2) | Measure | Yes | Chi phí cam kết | PO/Contract |
| FactProjectCost | ChangeOrderAmount | decimal(18,2) | Measure | Yes | Giá trị phát sinh | Approved CO only |
| FactProjectCost | PaymentAmount | decimal(18,2) | Measure | Yes | Đã thanh toán | Paid status |
| FactProjectCost | CurrencyCode | nvarchar(10) | Attribute | No | Mã tiền tệ nguồn | Convert về VND |
| FactProjectCost | LastUpdatedDatetime | datetime2 | Audit | No | Watermark incremental | UTC |
| FactProgressTracking | ProgressTxnKey | bigint | PK | No | Khóa surrogate giao dịch tiến độ | Generated in DW |
| FactProgressTracking | ProjectKey | int | FK->DimProject | No | Liên kết dự án | Lookup |
| FactProgressTracking | DateKey | int | FK->DimDate | No | Ngày báo cáo | YYYYMMDD |
| FactProgressTracking | WorkPackageKey | int | FK->DimWorkPackage | No | Liên kết gói công việc | Lookup |
| FactProgressTracking | ContractorKey | int | FK->DimContractor | Yes | Nhà thầu thực hiện | Unknown=-1 |
| FactProgressTracking | PlannedQty | decimal(18,3) | Measure | No | Sản lượng kế hoạch | >=0 |
| FactProgressTracking | ActualCompletedQty | decimal(18,3) | Measure | No | Sản lượng hoàn thành thực tế | >=0 |
| FactProgressTracking | BaselineQty | decimal(18,3) | Measure | No | Khối lượng baseline | >=0 |
| FactProgressTracking | EarnedValue | decimal(18,2) | Measure | Yes | Giá trị EV | From baseline cost |
| FactProgressTracking | PlannedValue | decimal(18,2) | Measure | Yes | Giá trị PV | From baseline cost |
| FactProgressTracking | DelayDays | int | Measure | Yes | Số ngày trễ dự báo | Max(0, forecast-plan) |
| FactProgressTracking | LaborHours | decimal(18,2) | Measure | Yes | Giờ công thực tế | For productivity |
| FactProgressTracking | LastUpdatedDatetime | datetime2 | Audit | No | Watermark incremental | UTC |
| DimProject | ProjectKey | int | PK | No | Khóa surrogate dự án | Identity |
| DimProject | ProjectCode | nvarchar(30) | BK | No | Mã dự án nghiệp vụ | Unique |
| DimProject | ProjectName | nvarchar(255) | Attribute | No | Tên dự án | - |
| DimProject | ProjectType | nvarchar(50) | Attribute | Yes | Loại dự án | Controlled list |
| DimProject | Region | nvarchar(50) | Attribute | Yes | Miền/vùng | North/Central/South |
| DimProject | Status | nvarchar(30) | Attribute | No | Trạng thái dự án | Active/Closing/Closed |
| DimProject | ProjectManagerUPN | nvarchar(255) | Attribute | Yes | UPN quản lý dự án | For RLS |
| DimMaterial | MaterialKey | int | PK | No | Khóa surrogate vật tư | Identity |
| DimMaterial | MaterialCode | nvarchar(50) | BK | No | Mã vật tư | Unique |
| DimMaterial | MaterialName | nvarchar(255) | Attribute | No | Tên vật tư | - |
| DimMaterial | MaterialGroup | nvarchar(100) | Attribute | No | Nhóm vật tư | Standardized |
| DimMaterial | Unit | nvarchar(20) | Attribute | No | Đơn vị chuẩn | kg/tấn/m3 |
| DimMaterial | StandardUnitCost | decimal(18,2) | Attribute | Yes | Đơn giá chuẩn | VND |
| DimContractor | ContractorKey | int | PK | No | Khóa surrogate nhà thầu | Identity |
| DimContractor | ContractorCode | nvarchar(30) | BK | No | Mã nhà thầu | Unique |
| DimContractor | ContractorName | nvarchar(255) | Attribute | No | Tên nhà thầu | - |
| DimContractor | ContractorType | nvarchar(50) | Attribute | Yes | Main/Sub/Supplier | Controlled list |
| DimContractor | CompanyCode | nvarchar(30) | Attribute | Yes | Mã công ty | For RLS |
| DimDate | DateKey | int | PK | No | Khóa ngày YYYYMMDD | Calendar table |
| DimDate | FullDate | date | Attribute | No | Ngày thực | - |
| DimDate | MonthNo | tinyint | Attribute | No | Tháng | 1-12 |
| DimDate | QuarterNo | tinyint | Attribute | No | Quý | 1-4 |
| DimDate | YearNo | smallint | Attribute | No | Năm | YYYY |
| DimWorkPackage | WorkPackageKey | int | PK | No | Khóa surrogate gói công việc | Identity |
| DimWorkPackage | WorkPackageCode | nvarchar(40) | BK | No | Mã gói công việc | Unique per project |
| DimWorkPackage | WorkPackageName | nvarchar(255) | Attribute | No | Tên gói công việc | - |
| DimWorkPackage | Discipline | nvarchar(50) | Attribute | Yes | Civil/MEP/Structure | Controlled list |
| DimCostCategory | CostCategoryKey | int | PK | No | Khóa surrogate nhóm chi phí | Identity |
| DimCostCategory | CostCategoryCode | nvarchar(30) | BK | No | Mã nhóm chi phí | Unique |
| DimCostCategory | CostCategoryName | nvarchar(255) | Attribute | No | Tên nhóm chi phí | - |
| DimCostCategory | ParentCategory | nvarchar(100) | Attribute | Yes | Nhóm cha | Hierarchy |
| SecurityUserProject | UserUPN | nvarchar(255) | Security Key | No | UPN người dùng | Lowercase |
| SecurityUserProject | ProjectKey | int | Security FK->DimProject | No | Dự án được cấp quyền | Bridge table |
| SecurityUserProject | CompanyCode | nvarchar(30) | Security Attribute | Yes | Đơn vị/nhà thầu | For contractor role |
| SecurityUserProject | RoleName | nvarchar(30) | Security Attribute | No | Admin/ProjectManager/SiteEngineer | Controlled list |
| SecurityUserProject | IsActive | bit | Security Attribute | No | Hiệu lực quyền | 1 active |

## Sheet: ModelRelationships

| From Table | From Column | To Table | To Column | Cardinality | Cross Filter | Active | Mục đích |
| --- | --- | --- | --- | --- | --- | --- | --- |
| FactMaterialConsumption | ProjectKey | DimProject | ProjectKey | Many-to-One | Single | Yes | Phân tích vật tư theo dự án |
| FactMaterialConsumption | MaterialKey | DimMaterial | MaterialKey | Many-to-One | Single | Yes | Phân tích theo nhóm vật liệu |
| FactMaterialConsumption | ContractorKey | DimContractor | ContractorKey | Many-to-One | Single | Yes | Phân tích theo nhà thầu |
| FactMaterialConsumption | DateKey | DimDate | DateKey | Many-to-One | Single | Yes | Phân tích theo thời gian |
| FactMaterialConsumption | WorkPackageKey | DimWorkPackage | WorkPackageKey | Many-to-One | Single | Yes | Phân tích theo gói công việc |
| FactProjectCost | ProjectKey | DimProject | ProjectKey | Many-to-One | Single | Yes | Chi phí theo dự án |
| FactProjectCost | CostCategoryKey | DimCostCategory | CostCategoryKey | Many-to-One | Single | Yes | Chi phí theo danh mục |
| FactProjectCost | ContractorKey | DimContractor | ContractorKey | Many-to-One | Single | Yes | Chi phí theo nhà thầu |
| FactProjectCost | DateKey | DimDate | DateKey | Many-to-One | Single | Yes | Chi phí theo thời gian |
| FactProgressTracking | ProjectKey | DimProject | ProjectKey | Many-to-One | Single | Yes | Tiến độ theo dự án |
| FactProgressTracking | WorkPackageKey | DimWorkPackage | WorkPackageKey | Many-to-One | Single | Yes | Tiến độ theo gói công việc |
| FactProgressTracking | ContractorKey | DimContractor | ContractorKey | Many-to-One | Single | Yes | Tiến độ theo nhà thầu |
| FactProgressTracking | DateKey | DimDate | DateKey | Many-to-One | Single | Yes | Tiến độ theo thời gian |
| SecurityUserProject | ProjectKey | DimProject | ProjectKey | Many-to-One | Single | Yes | Bridge bảo mật RLS theo dự án |

## Sheet: SourceMapping

| Source System | Source Table | Source Column | Power BI Table | Power BI Field | Data Type | Transformation |
| --- | --- | --- | --- | --- | --- | --- |
| SQLServer-ERP | dbo.ProjectMaster | ProjectCode | DimProject | ProjectCode | nvarchar(30) | TRIM + UPPER; reject null |
| SQLServer-ERP | dbo.ProjectMaster | ProjectName | DimProject | ProjectName | nvarchar(255) | Text.Clean + collapse spaces |
| SQLServer-ERP | dbo.ProjectMaster | ProjectType | DimProject | ProjectType | nvarchar(50) | Map via RefProjectType |
| SQLServer-ERP | dbo.ProjectMaster | RegionCode | DimProject | Region | nvarchar(50) | Join RefRegion |
| SQLServer-ERP | dbo.ProjectMaster | ProjectManagerEmail | DimProject | ProjectManagerUPN | nvarchar(255) | LOWER(TRIM(email)) |
| SQLServer-ERP | dbo.ProjectMaster | CompanyCode | DimProject | CompanyCode | nvarchar(30) | TRIM + UPPER |
| SQLServer-Procurement | dbo.MaterialMaster | MaterialCode | DimMaterial | MaterialCode | nvarchar(50) | TRIM |
| SQLServer-Procurement | dbo.MaterialMaster | MaterialName | DimMaterial | MaterialName | nvarchar(255) | Text.Clean |
| SQLServer-Procurement | dbo.MaterialMaster | MaterialGroupCode | DimMaterial | MaterialGroup | nvarchar(100) | Join RefMaterialGroup |
| SQLServer-Procurement | dbo.MaterialMaster | BaseUOM | DimMaterial | Unit | nvarchar(20) | Map to standard UOM |
| SQLServer-Procurement | dbo.MaterialMaster | StdUnitCost | DimMaterial | StandardUnitCost | decimal(18,2) | Cast decimal; negative->0 |
| SQLServer-Engineering | dbo.BOMNorm | NormPerUnitWork | DimMaterial | NormPerUnitWork | decimal(18,4) | Latest approved by EffectiveDate |
| SQLServer-PMIS | dbo.ContractorMaster | ContractorCode | DimContractor | ContractorCode | nvarchar(30) | TRIM + UPPER |
| SQLServer-PMIS | dbo.ContractorMaster | ContractorName | DimContractor | ContractorName | nvarchar(255) | Text.Clean |
| SQLServer-PMIS | dbo.ContractorMaster | ContractorType | DimContractor | ContractorType | nvarchar(50) | Map controlled list |
| SQLServer-PMIS | dbo.ContractorMaster | CompanyCode | DimContractor | CompanyCode | nvarchar(30) | TRIM + UPPER |
| SQLServer-PMIS | dbo.ContractorScore | PerformanceTier | DimContractor | PerformanceTier | nvarchar(20) | Latest score snapshot |
| SQLServer-PMIS | dbo.WorkPackagePlan | WorkPackageCode | DimWorkPackage | WorkPackageCode | nvarchar(40) | TRIM |
| SQLServer-PMIS | dbo.WorkPackagePlan | WorkPackageName | DimWorkPackage | WorkPackageName | nvarchar(255) | Text.Clean |
| SQLServer-PMIS | dbo.WorkPackagePlan | DisciplineCode | DimWorkPackage | Discipline | nvarchar(50) | Join RefDiscipline |
| SQLServer-PMIS | dbo.WorkPackagePlan | PlannedStartDate | DimWorkPackage | PlannedStartDateKey | int | Convert to DateKey |
| SQLServer-PMIS | dbo.WorkPackagePlan | PlannedFinishDate | DimWorkPackage | PlannedFinishDateKey | int | Convert to DateKey |
| SQLServer-Cost | dbo.CostCategoryMaster | CostCategoryCode | DimCostCategory | CostCategoryCode | nvarchar(30) | TRIM |
| SQLServer-Cost | dbo.CostCategoryMaster | CostCategoryName | DimCostCategory | CostCategoryName | nvarchar(255) | Text.Clean |
| SQLServer-Cost | dbo.CostCategoryMaster | CostType | DimCostCategory | CostTypeDirectIndirect | nvarchar(20) | Map Direct/Indirect |
| SQLServer-Cost | dbo.CostCategoryMaster | ParentCategory | DimCostCategory | ParentCategory | nvarchar(100) | Hierarchy flatten |
| SQLServer-Procurement | dbo.MaterialIssueLine | IssueTxnID | FactMaterialConsumption | MaterialTxnKey | bigint | Hash surrogate key |
| SQLServer-Procurement | dbo.MaterialIssueLine | ProjectCode | FactMaterialConsumption | ProjectKey | int | Lookup DimProject |
| SQLServer-Procurement | dbo.MaterialIssueLine | MaterialCode | FactMaterialConsumption | MaterialKey | int | Lookup DimMaterial |
| SQLServer-Procurement | dbo.MaterialIssueLine | ContractorCode | FactMaterialConsumption | ContractorKey | int | Lookup DimContractor |
| SQLServer-Procurement | dbo.MaterialIssueLine | IssueDate | FactMaterialConsumption | DateKey | int | Convert to DateKey |
| SQLServer-Procurement | dbo.MaterialIssueLine | WorkPackageCode | FactMaterialConsumption | WorkPackageKey | int | Lookup DimWorkPackage |
| SQLServer-Procurement | dbo.MaterialIssueLine | IssuedQty | FactMaterialConsumption | IssuedQty | decimal(18,3) | Cast decimal; null->0 |
| SQLServer-Procurement | dbo.MaterialReturnLine | ReturnQty | FactMaterialConsumption | ReturnQty | decimal(18,3) | Aggregate by txn; null->0 |
| SQLServer-Engineering | dbo.BOMNorm | NormQty | FactMaterialConsumption | NormQty | decimal(18,3) | Join by Project+WorkPackage+Material |
| SQLServer-Procurement | dbo.MaterialIssueLine | DocNo | FactMaterialConsumption | SourceDocNo | nvarchar(50) | TRIM |
| SQLServer-Procurement | dbo.MaterialIssueLine | LastUpdated | FactMaterialConsumption | LastUpdatedDatetime | datetime2 | UTC normalize |
| SQLServer-Cost | dbo.CostLedger | CostTxnID | FactProjectCost | CostTxnKey | bigint | Hash surrogate key |
| SQLServer-Cost | dbo.CostLedger | ProjectCode | FactProjectCost | ProjectKey | int | Lookup DimProject |
| SQLServer-Cost | dbo.CostLedger | ContractorCode | FactProjectCost | ContractorKey | int | Lookup DimContractor |
| SQLServer-Cost | dbo.CostLedger | PostingDate | FactProjectCost | DateKey | int | Convert to DateKey |
| SQLServer-Cost | dbo.CostLedger | CostCategoryCode | FactProjectCost | CostCategoryKey | int | Lookup DimCostCategory |
| SQLServer-Cost | dbo.BudgetBaseline | BudgetAmount | FactProjectCost | BudgetAmount | decimal(18,2) | Latest approved baseline only |
| SQLServer-Cost | dbo.CostLedger | ActualAmount | FactProjectCost | ActualAmount | decimal(18,2) | Exclude reversal entries |
| SQLServer-Cost | dbo.CommitmentLedger | CommittedAmount | FactProjectCost | CommittedAmount | decimal(18,2) | Aggregate by project/date/category |
| SQLServer-Cost | dbo.ChangeOrder | ChangeOrderAmount | FactProjectCost | ChangeOrderAmount | decimal(18,2) | Approved status only |
| SQLServer-Cost | dbo.PaymentCertificate | PaymentAmount | FactProjectCost | PaymentAmount | decimal(18,2) | Paid status only |
| SQLServer-Cost | dbo.CostLedger | CurrencyCode | FactProjectCost | CurrencyCode | nvarchar(10) | TRIM + UPPER |
| SQLServer-Cost | dbo.CostLedger | LastUpdated | FactProjectCost | LastUpdatedDatetime | datetime2 | UTC normalize |
| SQLServer-PMIS | dbo.ProgressDaily | ProgressTxnID | FactProgressTracking | ProgressTxnKey | bigint | Hash surrogate key |
| SQLServer-PMIS | dbo.ProgressDaily | ProjectCode | FactProgressTracking | ProjectKey | int | Lookup DimProject |
| SQLServer-PMIS | dbo.ProgressDaily | WorkPackageCode | FactProgressTracking | WorkPackageKey | int | Lookup DimWorkPackage |
| SQLServer-PMIS | dbo.ProgressDaily | ContractorCode | FactProgressTracking | ContractorKey | int | Lookup DimContractor |
| SQLServer-PMIS | dbo.ProgressDaily | ReportDate | FactProgressTracking | DateKey | int | Convert to DateKey |
| SQLServer-PMIS | dbo.ProgressDaily | PlannedQty | FactProgressTracking | PlannedQty | decimal(18,3) | Cast decimal |
| SQLServer-PMIS | dbo.ProgressDaily | ActualCompletedQty | FactProgressTracking | ActualCompletedQty | decimal(18,3) | Cast decimal |
| SQLServer-PMIS | dbo.ProgressDaily | BaselineQty | FactProgressTracking | BaselineQty | decimal(18,3) | Lookup by WorkPackageKey |
| SQLServer-PMIS | dbo.ProgressDaily | DelayDays | FactProgressTracking | DelayDays | int | If negative then 0 |
| SQLServer-PMIS | dbo.ProgressDaily | LaborHours | FactProgressTracking | LaborHours | decimal(18,2) | Null->0 |
| SQLServer-PMIS | dbo.ProgressDaily | LastUpdated | FactProgressTracking | LastUpdatedDatetime | datetime2 | UTC normalize |
| SQLServer-Identity | dbo.UserProjectAccess | UserEmail | SecurityUserProject | UserUPN | nvarchar(255) | LOWER(TRIM(email)) |
| SQLServer-Identity | dbo.UserProjectAccess | ProjectCode | SecurityUserProject | ProjectKey | int | Lookup DimProject |
| SQLServer-Identity | dbo.UserProjectAccess | CompanyCode | SecurityUserProject | CompanyCode | nvarchar(30) | TRIM + UPPER |
| SQLServer-Identity | dbo.UserProjectAccess | RoleName | SecurityUserProject | RoleName | nvarchar(30) | Map approved role list |
| SQLServer-Identity | dbo.UserProjectAccess | IsActive | SecurityUserProject | IsActive | bit | Cast bit |

## Sheet: DAXLogic

| Loại | Tên logic | Công thức DAX đầy đủ | Giải thích | Test case |
| --- | --- | --- | --- | --- |
| Measure | Total Material Quantity | Total Material Quantity =<br>SUMX(<br>    FactMaterialConsumption,<br>    FactMaterialConsumption[IssuedQty] - FactMaterialConsumption[ReturnQty]<br>) | Tổng khối lượng vật tư ròng trong filter context. | Đối chiếu với tổng NetQty cùng bộ lọc. |
| Measure | Norm Quantity | Norm Quantity =<br>SUM ( FactMaterialConsumption[NormQty] ) | Tổng định mức vật tư theo BOM approved. | Nếu thiếu BOM cần log DQ. |
| Measure | OverNorm Quantity | OverNorm Quantity =<br>SUMX(<br>    FactMaterialConsumption,<br>    MAX ( FactMaterialConsumption[NetQty] - FactMaterialConsumption[NormQty], 0 )<br>) | Khối lượng vượt định mức transaction-level. | Giá trị không được âm. |
| Measure | Material Overuse % | Material Overuse % =<br>DIVIDE ( [OverNorm Quantity], [Norm Quantity] ) | Tỷ lệ overuse để cảnh báo đỏ >10%. | Norm=0 trả BLANK. |
| Measure | Actual Cost | Actual Cost =<br>SUM ( FactProjectCost[ActualAmount] ) | Tổng chi phí thực tế. | Đối soát CostLedger theo ngày. |
| Measure | Budget Cost | Budget Cost =<br>SUM ( FactProjectCost[BudgetAmount] ) | Tổng ngân sách baseline approved. | Chỉ lấy baseline latest approved. |
| Measure | Budget Variance | Budget Variance =<br>[Actual Cost] - [Budget Cost] | Chênh lệch tuyệt đối actual vs budget. | Dương là vượt ngân sách. |
| Measure | Budget Variance % | Budget Variance % =<br>DIVIDE ( [Budget Variance], [Budget Cost] ) | Tỷ lệ vượt/tiết kiệm ngân sách. | Budget=0 trả BLANK. |
| Measure | Planned Progress % | Planned Progress % =<br>DIVIDE(<br>    SUM(FactProgressTracking[PlannedQty]),<br>    SUM(FactProgressTracking[BaselineQty])<br>) | Mức hoàn thành kế hoạch. | Kỳ vọng trong khoảng 0%-100%. |
| Measure | Actual Progress % | Actual Progress % =<br>VAR _progress = DIVIDE(<br>    SUM(FactProgressTracking[ActualCompletedQty]),<br>    SUM(FactProgressTracking[BaselineQty])<br>)<br>RETURN IF(_progress > 1, 1, _progress) | Mức hoàn thành thực tế, cap tối đa 100%. | Baseline=0 trả BLANK. |
| Measure | SPI | SPI =<br>DIVIDE ( [Earned Value], [Planned Value] ) | Schedule Performance Index. | SPI<0.95 cảnh báo đỏ. |
| Measure | CPI | CPI =<br>DIVIDE ( [Earned Value], [Actual Cost] ) | Cost Performance Index. | CPI<0.95 cảnh báo đỏ. |
| Measure | Rolling 3M Actual Cost | Rolling 3M Actual Cost =<br>CALCULATE(<br>    [Actual Cost],<br>    DATESINPERIOD(DimDate[FullDate], MAX(DimDate[FullDate]), -3, MONTH)<br>) | Xu hướng chi phí 3 tháng gần nhất. | So sánh trend theo từng dự án. |
| Measure | Delay Risk Level | Delay Risk Level =<br>VAR _delay = [Delay Days]<br>VAR _spi = [SPI]<br>RETURN<br>SWITCH(<br>    TRUE(),<br>    _delay >= 14 \|\| _spi < 0.9, "High",<br>    _delay >= 7 \|\| _spi < 0.95, "Medium",<br>    "Low"<br>) | Phân tầng mức rủi ro delay. | Kiểm tra biên tại delay=7 và 14. |
| Calculated Column | FactProjectCost[VarianceFlag] | VarianceFlag =<br>VAR _pct = DIVIDE(FactProjectCost[ActualAmount]-FactProjectCost[BudgetAmount], FactProjectCost[BudgetAmount])<br>RETURN<br>SWITCH(<br>    TRUE(),<br>    ISBLANK(_pct), "No Budget",<br>    _pct > 0.1, "Red",<br>    _pct > 0.05, "Yellow",<br>    "Green"<br>) | Phân loại màu cảnh báo transaction-level. | Dùng conditional formatting matrix. |

## Sheet: BusinessRules

| Rule ID | Phân hệ | Luật nghiệp vụ chi tiết | Điểm triển khai | Xử lý ngoại lệ | Data Owner |
| --- | --- | --- | --- | --- | --- |
| BR-01 | Material | Mã vật tư phải map MaterialGroup; không map gán UNCLASSIFIED và alert 08:00 mỗi ngày. | ETL SQL + Power Query | Vẫn load nhưng loại khỏi KPI chiến lược. | MDM Team |
| BR-02 | Material | NormQty lấy theo BOM approved mới nhất có EffectiveDate <= ngày giao dịch. | ETL SQL | Không có BOM thì Overuse KPI trả BLANK và log DQ. | Engineering Control |
| BR-03 | Project | Chỉ load dự án Status IN ('Active','Closing'); Closed giữ tối đa 24 tháng. | ETL SQL | Audit sâu dùng workspace archive. | PMO |
| BR-04 | Cost | ActualAmount loại bút toán reversal/cancelled theo trạng thái chứng từ. | ETL SQL | Reversal đến sau cutoff ghi adjustment kỳ kế tiếp. | Finance |
| BR-05 | Cost | Quy đổi currency về VND theo tỷ giá cuối tháng; thiếu rate dùng nearest previous. | Power Query + SQL | Thiếu rate >7 ngày đánh critical. | Treasury |
| BR-06 | Progress | DelayDays = max(0, ForecastFinishDate - PlannedFinishDate). | ETL SQL | Forecast null dùng RevisedFinishDate. | Planning Office |
| BR-07 | Progress | Actual Progress % cap 100% để tránh outlier do baseline cập nhật trễ. | DAX | Record >100% được log để PM xác nhận. | Planning Office |
| BR-08 | Contractor | Productivity Index chỉ tính khi LaborHours>0 và ActualCompletedQty>0. | DAX | Record không hợp lệ đưa vào trang Data Quality. | Contract Management |
| BR-09 | Security | User chỉ xem dự án mapping trong SecurityUserProject và IsActive=1. | RLS DAX | User không mapping sẽ không thấy dữ liệu. | IT Security |
| BR-10 | Governance | Khóa số liệu tháng vào T+3 18:00; sửa sau khóa cần approval ticket. | Process + SQL | Lưu audit trail DataCorrectionLog. | PMO + Data Governance |
| BR-11 | Dashboard | Executive dashboard chỉ hiển thị Top 15 dự án theo Actual Cost để tối ưu hiệu năng. | Visual Filter | Danh sách đầy đủ ở drillthrough. | BI Team |
| BR-12 | Quality | Đối soát KPI semantic vs source hằng ngày; sai lệch cho phép <=0.5%. | SQL Validation Job | Lệch >0.5% thì refresh fail + gửi alert. | Data Quality Team |

## Sheet: RLS

| Role | Bảng áp dụng filter | DAX Filter | Phạm vi truy cập | Thiết lập Power BI Service | Kịch bản kiểm thử |
| --- | --- | --- | --- | --- | --- |
| Admin | DimProject | TRUE() | Xem toàn bộ dữ liệu tất cả dự án. | Gán Azure AD group BI-Admins vào role Admin. | admin@abc.com phải thấy đủ 20 dự án. |
| Project Manager | SecurityUserProject | SecurityUserProject[UserUPN] = USERPRINCIPALNAME() && SecurityUserProject[RoleName] = "ProjectManager" && SecurityUserProject[IsActive] = TRUE() | Chỉ xem dữ liệu dự án được phân công. | Relationship SecurityUserProject[ProjectKey] -> DimProject[ProjectKey], single direction. | pm.north@abc.com chỉ thấy dự án miền Bắc được gán. |
| Site Engineer | SecurityUserProject | SecurityUserProject[UserUPN] = USERPRINCIPALNAME() && SecurityUserProject[RoleName] = "SiteEngineer" && SecurityUserProject[IsActive] = TRUE() | Xem vật tư + tiến độ site phụ trách; không xem dashboard chi phí tổng. | Tách app permission, không publish trang Cost Analysis cho role này. | site.hcm@abc.com không truy cập trang chi phí. |
| Contractor Viewer | DimContractor | DimContractor[CompanyCode] IN CALCULATETABLE(VALUES(SecurityUserProject[CompanyCode]), SecurityUserProject[UserUPN]=USERPRINCIPALNAME(), SecurityUserProject[RoleName]="ContractorViewer", SecurityUserProject[IsActive]=TRUE()) | Nhà thầu chỉ xem dữ liệu company code của mình. | Disable export underlying data với app external. | contractor.a@partner.com chỉ thấy CNT-A. |
