# Basic Design

## Sheet: Header

| Mục | Nội dung |
| --- | --- |
| Tên dự án | Enterprise Construction Intelligence Platform (ECIP) - Phase 1 |
| Khách hàng | Tổng Công ty Hạ tầng ABC |
| Phạm vi triển khai | Triển khai BI cho 20 dự án xây dựng dân dụng + công nghiệp, tập trung vật tư, chi phí, tiến độ và hiệu suất nhà thầu. |
| Nguồn dữ liệu chính | SQL Server (ERP, PMIS, Procurement, Cost Control) |
| Công nghệ sử dụng | SQL Server 2022, SSIS, Power Query M, DAX, Power BI Service, Azure AD |
| Phiên bản tài liệu | v1.0 - Basic Design |
| Người tạo / Ngày tạo | Senior BI Solution Architect / 2026-02-10 |
| Môi trường | DEV / UAT / PROD (tách gateway + workspace + dataset) |

## Sheet: History

| Version | Ngày chỉnh sửa | Người chỉnh sửa | Mô tả thay đổi |
| --- | --- | --- | --- |
| v0.1 | 2026-01-20 | PMO Team | Khởi tạo template tài liệu thiết kế BI. |
| v0.5 | 2026-02-02 | BI Architect | Hoàn thiện module nghiệp vụ và KPI mức cao. |
| v0.9 | 2026-02-07 | Data Lead | Rà soát mô hình dữ liệu và naming convention. |
| v1.0 | 2026-02-10 | Senior BI Solution Architect | Phát hành baseline cho stakeholder và developer. |

## Sheet: Overview

| Hạng mục | Mô tả |
| --- | --- |
| Kiến trúc tổng thể | Nguồn SQL Server -> ETL (SSIS + SQL Agent) -> Data Warehouse (Raw/Clean/Semantic) -> Power BI Dataset -> Dashboard trên Power BI Service. |
| Luồng dữ liệu | Extract incremental theo LastUpdatedDatetime; chuẩn hóa master data ở Clean; build star schema ở Semantic; refresh dataset 6 lần/ngày. |
| Phân tầng Raw | Lưu dữ liệu nguồn gần nguyên bản, thêm ETLBatchID và thời gian extract để truy vết. |
| Phân tầng Clean | Chuẩn hóa đơn vị đo, mã dự án, mã vật tư, mã nhà thầu; xử lý bản ghi trùng và null key. |
| Phân tầng Semantic | Tối ưu cho Power BI bằng star schema, surrogate key int, measure tính bằng DAX. |
| Sơ đồ ASCII | [SQL Server: ERP \| PMIS \| Procurement \| Cost]<br>                 \|<br>          [SSIS + SQL Agent]<br>                 \|<br>          [DW_Raw] -> [DW_Clean] -> [DW_Semantic]<br>                                       \|<br>                              [Power BI Dataset]<br>                                       \|<br> [Executive \| Cost \| Progress \| Material Dashboards]<br>                                       \|<br>                    [Power BI Service + RLS + Alerts] |

## Sheet: Modules

| Module ID | Tên Module | Mô tả nghiệp vụ | Người dùng chính | Dữ liệu đầu vào |
| --- | --- | --- | --- | --- |
| M01 | Quản lý vật liệu xây dựng | Theo dõi nhập-xuất-trả-tồn vật tư theo dự án/gói công việc/nhà thầu; cảnh báo vượt định mức. | Project Manager, Site Engineer, Procurement | MaterialIssueLine, MaterialReturnLine, BOMNorm, ProjectMaster |
| M02 | Theo dõi tiến độ thi công | So sánh tiến độ thực tế và kế hoạch baseline theo tuần/tháng. | Planning Engineer, PM | ProgressDaily, WorkPackagePlan, BaselineSchedule |
| M03 | Quản lý chi phí & dự toán | Phân tích chi phí thực tế, ngân sách, cam kết chi và phát sinh. | Finance Controller, PMO | CostLedger, BudgetBaseline, ChangeOrder, PaymentCertificate |
| M04 | Hiệu suất nhà thầu | Đo lường năng suất, độ đúng hạn giao hàng, mức độ tuân thủ SLA. | Contract Manager, PMO | ContractorMaster, ContractorKPI, DeliveryPerformance |
| M05 | Nghiệm thu khối lượng | Theo dõi khối lượng nghiệm thu và trạng thái thanh toán theo đợt. | QS, Site Engineer | AcceptanceMinutes, BillingProgress |

## Sheet: Dashboards

| Tên Dashboard | Mục tiêu phân tích | Người sử dụng | Bố cục chi tiết | Mockup ASCII | Insight chính |
| --- | --- | --- | --- | --- | --- |
| Executive Portfolio Overview | Theo dõi tình trạng toàn bộ danh mục dự án ở cấp điều hành. | CEO, COO, PMO Director | Top: 6 KPI card. Left: Column Actual vs Budget. Right: Line Cashflow theo tháng. Bottom: Matrix top overspend. | [KPI x6]<br>[Column Actual vs Budget] [Line Cashflow]<br>[Matrix Overspend] | Nhận diện sớm dự án vượt ngân sách và chậm tiến độ để tái phân bổ nguồn lực. |
| Material Consumption Control | Giám sát tiêu thụ vật tư theo nhóm vật liệu, dự án và nhà thầu. | Project Manager, Site Engineer | Top-left KPI card; top-right donut vật tư; middle stacked column theo dự án; bottom bảng giao dịch chi tiết. | [KPI]<br>[Donut Material Mix] [Stacked Column]<br>[Transaction Table] | Phát hiện nhóm vật tư gây overuse và điểm nóng hao hụt. |
| Cost vs Budget Deep Dive | Phân tích sai lệch ngân sách theo category và nhà thầu. | Finance Controller, PM | Top KPI; left waterfall variance bridge; right bar theo cost category; bottom matrix drilldown. | [KPI]<br>[Waterfall] [Bar]<br>[Matrix Drilldown] | Khoanh vùng nguyên nhân vượt chi phí để hành động cắt giảm. |
| Progress & Delay Risk | Theo dõi tiến độ và cảnh báo rủi ro trễ milestone. | Planning Engineer, PM | Top KPI; left line planned vs actual; right heatmap delay; bottom table milestone. | [KPI]<br>[Line Planned vs Actual] [Heatmap]<br>[Milestone Table] | Ưu tiên xử lý work package có delay > 7 ngày hoặc SPI < 0.95. |

## Sheet: KPI

| KPI Code | KPI | Định nghĩa nghiệp vụ | Công thức logic | Đơn vị đo | Ngưỡng cảnh báo | Tần suất |
| --- | --- | --- | --- | --- | --- | --- |
| KPI-01 | Tổng khối lượng vật liệu | Tổng lượng vật tư xuất dùng ròng trong kỳ. | SUM(IssuedQty - ReturnQty) | Tấn/m3/cây | MoM > +15%: vàng; > +25%: đỏ | Ngày |
| KPI-02 | Tỷ lệ tiêu thụ vật liệu theo loại | Tỷ trọng từng nhóm vật liệu trên tổng tiêu thụ. | MaterialGroupQty / TotalQty | % | Nhóm bất kỳ > 40% cần kiểm tra định mức | Ngày |
| KPI-03 | % vượt định mức vật tư | Mức vượt so với định mức BOM đã duyệt. | (ActualQty - NormQty) / NormQty | % | >10%: đỏ | Ngày |
| KPI-04 | Chi phí thực tế | Tổng chi phí thực tế phát sinh. | SUM(ActualAmount) | VND | So với baseline dự án | Ngày |
| KPI-05 | Chênh lệch chi phí | Sai lệch tuyệt đối giữa thực tế và dự toán. | ActualAmount - BudgetAmount | VND | Dương là vượt ngân sách | Ngày |
| KPI-06 | Budget Variance % | Tỷ lệ vượt/tiết kiệm ngân sách. | (Actual - Budget) / Budget | % | >5%: vàng; >10%: đỏ | Ngày |
| KPI-07 | Tiến độ thực tế vs kế hoạch | Mức hoàn thành thực tế so với kế hoạch. | ActualCompletedQty / PlannedQty | % | <95%: cảnh báo | Ngày |
| KPI-08 | SPI | Schedule Performance Index. | EarnedValue / PlannedValue | Index | <0.95: đỏ | Tuần |
| KPI-09 | CPI | Cost Performance Index. | EarnedValue / ActualCost | Index | <0.95: đỏ | Tuần |

## Sheet: DataModel

| Tên bảng | Loại bảng | Grain / mức chi tiết | Khóa chính | Khóa ngoại | Chức năng | Cột chính |
| --- | --- | --- | --- | --- | --- | --- |
| FactMaterialConsumption | Fact | 1 dòng / giao dịch xuất-trả vật tư theo ngày và work package | MaterialTxnKey | ProjectKey, MaterialKey, ContractorKey, DateKey, WorkPackageKey | Theo dõi tiêu thụ vật tư & định mức | IssuedQty, ReturnQty, NetQty, NormQty, OverNormQty |
| FactProjectCost | Fact | 1 dòng / phát sinh chi phí theo ngày và cost category | CostTxnKey | ProjectKey, ContractorKey, DateKey, CostCategoryKey | Theo dõi chi phí thực tế vs dự toán | BudgetAmount, ActualAmount, CommittedAmount |
| FactProgressTracking | Fact | 1 dòng / tiến độ theo ngày và gói công việc | ProgressTxnKey | ProjectKey, DateKey, WorkPackageKey, ContractorKey | So sánh tiến độ kế hoạch vs thực tế | PlannedQty, ActualCompletedQty, DelayDays |
| DimProject | Dimension | 1 dòng / dự án | ProjectKey | - | Master dữ liệu dự án | ProjectCode, ProjectName, Region, Status |
| DimMaterial | Dimension | 1 dòng / mã vật tư | MaterialKey | - | Master vật tư | MaterialCode, MaterialGroup, Unit, StandardUnitCost |
| DimContractor | Dimension | 1 dòng / nhà thầu | ContractorKey | - | Master nhà thầu | ContractorCode, ContractorType, CompanyCode |
| DimDate | Dimension | 1 dòng / ngày | DateKey | - | Calendar cho time intelligence | FullDate, Month, Quarter, Year, ISOWeek |
| DimWorkPackage | Dimension | 1 dòng / gói công việc | WorkPackageKey | - | Chuẩn hóa phạm vi tiến độ | WorkPackageCode, Discipline, PlannedStart, PlannedFinish |
| DimCostCategory | Dimension | 1 dòng / nhóm chi phí | CostCategoryKey | - | Phân tích sai lệch theo nhóm chi phí | CostCategoryCode, ParentCategory, CostType |

## Sheet: SourceMapping

| Source System | Source Table | Source Column | Power BI Table | Power BI Field | Data Type | Transformation |
| --- | --- | --- | --- | --- | --- | --- |
| SQLServer-ERP | dbo.ProjectMaster | ProjectCode | DimProject | ProjectCode | nvarchar(30) | Text.Trim + Uppercase |
| SQLServer-ERP | dbo.ProjectMaster | ProjectName | DimProject | ProjectName | nvarchar(255) | Text.Clean |
| SQLServer-ERP | dbo.ProjectMaster | ProjectManagerEmail | DimProject | ProjectManagerUPN | nvarchar(255) | Lowercase + trim |
| SQLServer-Procurement | dbo.MaterialMaster | MaterialCode | DimMaterial | MaterialCode | nvarchar(50) | Text.Trim |
| SQLServer-Procurement | dbo.MaterialMaster | MaterialGroup | DimMaterial | MaterialGroup | nvarchar(100) | Map theo từ điển nhóm |
| SQLServer-Procurement | dbo.MaterialIssueLine | IssuedQty | FactMaterialConsumption | IssuedQty | decimal(18,3) | Cast decimal; null=0 |
| SQLServer-Procurement | dbo.MaterialReturnLine | ReturnQty | FactMaterialConsumption | ReturnQty | decimal(18,3) | Cast decimal; null=0 |
| SQLServer-Procurement | dbo.MaterialIssueLine | UnitPrice | FactMaterialConsumption | UnitPrice | decimal(18,2) | Cast decimal |
| SQLServer-Cost | dbo.CostLedger | ActualAmount | FactProjectCost | ActualAmount | decimal(18,2) | Loại bút toán reversal |
| SQLServer-Cost | dbo.BudgetBaseline | BudgetAmount | FactProjectCost | BudgetAmount | decimal(18,2) | Giữ baseline approved mới nhất |
| SQLServer-PMIS | dbo.ProgressDaily | PlannedQty | FactProgressTracking | PlannedQty | decimal(18,3) | Chuẩn hóa đơn vị |
| SQLServer-PMIS | dbo.ProgressDaily | ActualCompletedQty | FactProgressTracking | ActualCompletedQty | decimal(18,3) | Null=0 |
| SQLServer-PMIS | dbo.ContractorMaster | ContractorCode | DimContractor | ContractorCode | nvarchar(30) | Text.Trim |
| SQLServer-Cost | dbo.CostCategoryMaster | CostCategoryCode | DimCostCategory | CostCategoryCode | nvarchar(30) | Text.Trim |

## Sheet: DAXLogic

| Loại | Tên logic | Công thức DAX | Giải thích |
| --- | --- | --- | --- |
| Measure | Total Material Quantity | Total Material Quantity =<br>SUMX(<br>    FactMaterialConsumption,<br>    FactMaterialConsumption[IssuedQty] - FactMaterialConsumption[ReturnQty]<br>) | Tổng khối lượng vật tư xuất dùng ròng. |
| Measure | Actual Cost | Actual Cost =<br>SUM ( FactProjectCost[ActualAmount] ) | Tổng chi phí thực tế. |
| Measure | Budget Cost | Budget Cost =<br>SUM ( FactProjectCost[BudgetAmount] ) | Tổng ngân sách baseline. |
| Measure | Budget Variance % | Budget Variance % =<br>DIVIDE ( [Actual Cost] - [Budget Cost], [Budget Cost] ) | Tỷ lệ vượt/tiết kiệm ngân sách. |
| Measure | Schedule Completion % | Schedule Completion % =<br>DIVIDE (<br>    SUM ( FactProgressTracking[ActualCompletedQty] ),<br>    SUM ( FactProgressTracking[PlannedQty] )<br>) | Mức độ hoàn thành thực tế so với kế hoạch. |
| Calculated Column | FactMaterialConsumption[OverNormFlag] | OverNormFlag =<br>IF ( FactMaterialConsumption[OverNormQty] > 0, "Over", "Within Norm" ) | Đánh dấu giao dịch vượt định mức. |

## Sheet: BusinessRules

| Rule ID | Business Rule | Mô tả logic | Module áp dụng | Ví dụ / ngoại lệ |
| --- | --- | --- | --- | --- |
| BR-01 | Phân loại vật liệu | MaterialGroup được chuẩn hóa theo từ điển MDM; mã không khớp gán UNCLASSIFIED. | M01 | Mã mới chưa mapping cần xử lý trong 24h. |
| BR-02 | Định mức vật tư | NormQty lấy từ BOM approved mới nhất tại thời điểm giao dịch. | M01 | Nếu thiếu BOM thì không tính Overuse KPI. |
| BR-03 | Lọc dự án | Chỉ hiển thị dự án Status IN ('Active','Closing'). | M01-M05 | Dự án Closed đưa vào workspace archive. |
| BR-04 | Cảnh báo vượt chi phí | Variance% > 5% vàng; >10% đỏ. | M03 | Không áp dụng category Contingency. |
| BR-05 | Chuẩn hóa tiền tệ | Quy đổi chi phí về VND theo FX rate cuối tháng. | M03 | Thiếu rate dùng nearest previous rate. |
| BR-06 | Tính chậm tiến độ | DelayDays = max(0, ForecastFinishDate - PlannedFinishDate). | M02 | Delay âm ép về 0. |
| BR-07 | Năng suất nhà thầu | Productivity = ActualCompletedQty / LaborHour (LaborHour > 0). | M04 | Thiếu LaborHour loại khỏi ranking. |
| BR-08 | Khóa số liệu tháng | Chốt số liệu vào T+3 18:00; chỉnh sửa cần approval. | M01-M05 | Lưu audit trail DataCorrectionLog. |

## Sheet: RLS

| Role | Phạm vi truy cập | DAX Filter mẫu | Áp dụng | Ghi chú |
| --- | --- | --- | --- | --- |
| Admin | Toàn bộ dữ liệu | TRUE() | Toàn dataset | Chỉ cấp Azure AD group BI-Admins. |
| Project Manager | Chỉ dự án được phân công | DimProject[ProjectKey] IN CALCULATETABLE(VALUES(SecurityUserProject[ProjectKey]), SecurityUserProject[UserUPN]=USERPRINCIPALNAME(), SecurityUserProject[RoleName]="ProjectManager") | DimProject + tất cả fact | Bridge SecurityUserProject cập nhật hàng ngày. |
| Site Engineer | Chỉ site phụ trách | DimProject[ProjectKey] IN CALCULATETABLE(VALUES(SecurityUserProject[ProjectKey]), SecurityUserProject[UserUPN]=USERPRINCIPALNAME(), SecurityUserProject[RoleName]="SiteEngineer") | FactMaterialConsumption + FactProgressTracking | Không truy cập dashboard tài chính công ty. |
| Contractor Viewer | Theo CompanyCode nhà thầu | DimContractor[CompanyCode] IN CALCULATETABLE(VALUES(SecurityUserProject[CompanyCode]), SecurityUserProject[UserUPN]=USERPRINCIPALNAME()) | FactMaterialConsumption + FactProjectCost | Role ngoài tổ chức nội bộ. |
